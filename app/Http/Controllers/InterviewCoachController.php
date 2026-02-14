<?php

namespace App\Http\Controllers;

use App\Models\InterviewSession;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewCoachController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show interview coach dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $sessions = $user->interviewSessions()
            ->latest()
            ->paginate(10);

        $stats = [
            'total_sessions' => $user->interviewSessions()->count(),
            'total_questions' => $user->interviewSessions()->sum('questions_count'),
            'average_score' => $user->interviewSessions()->avg('average_score') ?? 0,
        ];

        return view('interview-coach.index', compact('sessions', 'stats'));
    }

    /**
     * Show practice interface
     */
    public function practice()
    {
        return view('interview-coach.practice');
    }

    /**
     * Generate interview questions
     */
    public function generateQuestions(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'experience_level' => 'required|in:entry,mid,senior',
            'question_count' => 'nullable|integer|min:3|max:10',
        ]);

        $user = Auth::user();
        $count = $request->question_count ?? 5;

        try {
            // Generate questions using AI with timeout handling
            $questions = $this->gemini->generateInterviewQuestions(
                $request->role,
                $request->experience_level,
                $count
            );

            // Fallback if AI fails or returns empty
            if (empty($questions)) {
                $questions = $this->getFallbackQuestions($request->role, $request->experience_level, $count);
            }

            // Create session
            $session = $user->interviewSessions()->create([
                'role' => $request->role,
                'experience_level' => $request->experience_level,
                'questions_data' => $questions,
                'answers_data' => [],
                'evaluations_data' => [],
                'questions_count' => count($questions),
                'started_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'questions' => $questions,
            ]);
        } catch (\Exception $e) {
            // Return fallback questions on error
            $questions = $this->getFallbackQuestions($request->role, $request->experience_level, $count);
            
            $session = $user->interviewSessions()->create([
                'role' => $request->role,
                'experience_level' => $request->experience_level,
                'questions_data' => $questions,
                'answers_data' => [],
                'evaluations_data' => [],
                'questions_count' => count($questions),
                'started_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'questions' => $questions,
                'fallback' => true,
            ]);
        }
    }

    /**
     * Get fallback questions when AI is unavailable
     */
    protected function getFallbackQuestions(string $role, string $level, int $count): array
    {
        $genericQuestions = [
            [
                'question' => 'Tell me about yourself and your background.',
                'type' => 'behavioral',
                'tips' => 'Focus on relevant experience and skills for this role.',
            ],
            [
                'question' => 'Why are you interested in this ' . $role . ' position?',
                'type' => 'behavioral',
                'tips' => 'Show enthusiasm and knowledge about the role.',
            ],
            [
                'question' => 'Describe a challenging project you worked on. What was your role and how did you overcome obstacles?',
                'type' => 'behavioral',
                'tips' => 'Use the STAR method: Situation, Task, Action, Result.',
            ],
            [
                'question' => 'What are your greatest strengths and how do they apply to this role?',
                'type' => 'behavioral',
                'tips' => 'Provide specific examples that demonstrate your strengths.',
            ],
            [
                'question' => 'Tell me about a time you had to work with a difficult team member. How did you handle it?',
                'type' => 'behavioral',
                'tips' => 'Show conflict resolution and communication skills.',
            ],
            [
                'question' => 'Where do you see yourself in 5 years?',
                'type' => 'behavioral',
                'tips' => 'Align your goals with the company\'s growth opportunities.',
            ],
            [
                'question' => 'Describe a situation where you had to learn something new quickly.',
                'type' => 'behavioral',
                'tips' => 'Demonstrate adaptability and learning agility.',
            ],
            [
                'question' => 'What is your approach to problem-solving?',
                'type' => 'technical',
                'tips' => 'Walk through your systematic approach with examples.',
            ],
            [
                'question' => 'How do you prioritize tasks when you have multiple deadlines?',
                'type' => 'situational',
                'tips' => 'Show time management and organizational skills.',
            ],
            [
                'question' => 'Why should we hire you for this position?',
                'type' => 'behavioral',
                'tips' => 'Summarize your unique value proposition.',
            ],
        ];

        return array_slice($genericQuestions, 0, min($count, count($genericQuestions)));
    }

    /**
     * Evaluate interview answer
     */
    public function evaluateAnswer(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:interview_sessions,id',
            'question_index' => 'required|integer|min:0',
            'question' => 'required|string',
            'answer' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        $session = InterviewSession::findOrFail($request->session_id);

        // Verify ownership
        if ($session->user_id !== $user->id) {
            abort(403);
        }

        // Get AI evaluation
        $evaluation = $this->gemini->evaluateInterviewAnswer(
            $request->question,
            $request->answer,
            $session->role
        );

        // Extract score from evaluation
        $score = $this->extractScore($evaluation);

        // Update session with answer and evaluation
        $answersData = $session->answers_data ?? [];
        $evaluationsData = $session->evaluations_data ?? [];
        $scores = $session->scores ?? [];

        $answersData[$request->question_index] = $request->answer;
        $evaluationsData[$request->question_index] = $evaluation;
        $scores[$request->question_index] = $score;

        $session->update([
            'answers_data' => $answersData,
            'evaluations_data' => $evaluationsData,
            'scores' => $scores,
            'average_score' => count($scores) > 0 ? array_sum($scores) / count($scores) : 0,
        ]);

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation,
            'score' => $score,
        ]);
    }

    /**
     * Show practice history
     */
    public function history()
    {
        $user = Auth::user();
        
        $sessions = $user->interviewSessions()
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->paginate(15);

        return view('interview-coach.history', compact('sessions'));
    }

    /**
     * Extract score from evaluation text
     */
    protected function extractScore(string $evaluation): int
    {
        // Try to find score in various formats
        if (preg_match('/(?:score|rating)[:\s]+(\d+)/i', $evaluation, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }
        
        if (preg_match('/(\d+)\/10/', $evaluation, $matches)) {
            return min(100, max(0, (int)$matches[1] * 10));
        }
        
        if (preg_match('/(\d+)\/5/', $evaluation, $matches)) {
            return min(100, max(0, (int)$matches[1] * 20));
        }

        // Default score based on keywords
        $positive = preg_match_all('/\b(excellent|great|good|strong|well)\b/i', $evaluation);
        $negative = preg_match_all('/\b(poor|weak|needs improvement|lacking)\b/i', $evaluation);
        
        return max(50, min(90, 70 + ($positive * 5) - ($negative * 10)));
    }
}
