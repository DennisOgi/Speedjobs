<?php

namespace App\Http\Controllers;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiFeedback;
use App\Models\AiReport;
use App\Models\Job;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AiCounselorController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show AI counselor dashboard (and widget entry point)
     */
    public function index()
    {
        // Handle guest users for testing
        if (!Auth::check()) {
            return view('ai-counselor.index', ['stats' => []]);
        }

        $user = Auth::user();
        
        // Stats for the "Pro" dashboard
        $stats = [
            'total_conversations' => $user->aiConversations()->count(),
            'active_conversations' => $user->aiConversations()->active()->count(),
            'total_messages' => AiMessage::whereIn('conversation_id', $user->aiConversations()->pluck('id'))->count(),
            'assessments_completed' => $user->assessmentResults()->count(),
            'active_pathway' => $user->activePathway,
        ];

        $conversations = $user->aiConversations()
            ->active()
            ->with('messages')
            ->recent()
            ->paginate(10);

        return view('ai-counselor.index', compact('conversations', 'stats'));
    }

    /**
     * Create a new conversation for the widget
     */
    public function createConversation(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        if (!$user->is_paid) {
            return response()->json(['error' => 'Premium feature required.'], 403);
        }

        $conversation = AiConversation::create([
            'user_id' => $user->id,
            'type' => $request->get('type', 'general'),
            'context_data' => [],
        ]);

        return response()->json([
            'id' => $conversation->id,
            'type' => $conversation->type,
        ]);
    }

    /**
     * Stream a chat response (SSE)
     */
    public function stream(Request $request, AiConversation $conversation)
    {
        $this->authorize('update', $conversation);
        if (!Auth::user()->is_paid) {
            return response()->json(['error' => 'Premium feature required.'], 403);
        }

        $request->validate(['message' => 'required|string|max:2000']);

        // Save User Message
        $conversation->messages()->create([
            'role' => 'user',
            'content' => $request->message,
        ]);

        $history = $conversation->messages()
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        // Streaming Response
        return response()->stream(function () use ($request, $conversation, $history) {
            $fullResponse = "";
            $stream = $this->gemini->streamMessage($request->message, $conversation->context_data ?? [], $history);

            foreach ($stream as $chunk) {
                 if (connection_aborted()) break;
                 // Send SSE event
                 echo "data: " . json_encode(['chunk' => $chunk]) . "\n\n";
                 $fullResponse .= $chunk;
                 ob_flush();
                 flush();
            }

            // Save Assistant Message when stream completes
            $conversation->messages()->create([
                'role' => 'assistant',
                'content' => $fullResponse,
            ]);
            $conversation->touch('last_message_at');

            echo "event: done\n";
            echo "data: {}\n\n";

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // For Nginx
        ]);
    }

    /**
     * Analyze a job match
     */
    public function analyzeJob(Job $job)
    {
        if (!Auth::user()->is_paid) abort(403, 'Premium feature.');

        $user = Auth::user();
        $cacheKey = "job_analysis_{$user->id}_{$job->id}";

        $analysis = cache()->remember($cacheKey, 3600, function() use ($user, $job) {
             return $this->gemini->analyzeJobMatch($job->toArray(), $this->getUserContext());
        });

        return response()->json($analysis);
    }

    /**
     * Get or generate profile report
     */
    public function profileReport(Request $request)
    {
        if (!Auth::user()->is_paid) abort(403, 'Premium feature.');

        $user = Auth::user();
        $forceRefresh = $request->query('refresh') === 'true';
        
        // Check for existing valid report unless force refresh is requested
        if (!$forceRefresh) {
            $report = AiReport::where('user_id', $user->id)
                ->where('type', 'profile_report')
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
                
            if ($report) {
                // Parse content if it's a string
                $reportContent = is_string($report->content) ? json_decode($report->content, true) : $report->content;
                return response()->json($reportContent);
            }
        }

        // Generate new report
        $content = $this->gemini->generateProfileReport($this->getUserContext());
        
        // Store as JSON string
        $report = AiReport::create([
            'user_id' => $user->id,
            'type' => 'profile_report',
            'content' => json_encode($content),
            'expires_at' => now()->addDays(7),
        ]);

        // Parse content if it's a string
        $reportContent = is_string($report->content) ? json_decode($report->content, true) : $report->content;
        
        // Return the content directly (not wrapped in another object)
        return response()->json($reportContent);
    }

    // ... (Keep existing methods for CRUD/legacy support if needed, e.g. create, show, archive, destroy)

    public function show(AiConversation $conversation)
    {
        $this->authorize('view', $conversation);
        return view('ai-counselor.chat', compact('conversation'));
    }

    public function create(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        if (!Auth::user()->is_paid) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Premium feature required.'], 403);
            }
            return redirect()->route('profile.edit')->with('error', 'Please upgrade to Premium to access the AI Career Counselor.');
        }
        
        $conversation = Auth::user()->aiConversations()->create([
            'conversation_type' => $request->get('type', 'general'),
            'status' => 'active',
            'context_data' => $this->getUserContext(),
            'last_message_at' => now(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'id' => $conversation->id,
                'welcome_message' => "Hello! I'm your AI Career Counselor. How can I help you today?"
            ]);
        }

        return redirect()->route('ai-counselor.show', $conversation);
    }
    
    public function destroy(AiConversation $conversation)
    {
        $this->authorize('delete', $conversation);
        $conversation->delete();
        return redirect()->route('ai-counselor.index');
    }

    protected function getUserContext(): array
    {
        $user = Auth::user();
        return [
            'name' => $user->name,
            'role' => $user->role,
            'skills' => $user->skills,
            'experience' => $user->experience_level,
            'field' => $user->field_of_study,
            // Include recent activity if possible
        ];
    }
}
