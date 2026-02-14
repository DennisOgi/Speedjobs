<?php

namespace App\Http\Controllers;

use App\Models\AiSession;
use App\Models\AiSessionStep;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiSessionController extends Controller
{
    protected GeminiService $gemini;

    // Define the question flow for each module
    protected array $careerAssessmentQuestions = [
        ['type' => 'choice', 'question' => 'What type of work environment do you prefer?', 'options' => ['Fast-paced startup', 'Structured corporate', 'Creative agency', 'Remote/Flexible', 'Non-profit/Mission-driven']],
        ['type' => 'choice', 'question' => 'Which of these activities energizes you most?', 'options' => ['Solving complex problems', 'Leading and inspiring others', 'Creating something new', 'Helping and mentoring people', 'Organizing and optimizing processes']],
        ['type' => 'choice', 'question' => 'How do you prefer to work?', 'options' => ['Independently with minimal supervision', 'Collaboratively in a team', 'Leading a team', 'As part of a pair/partnership', 'Varies depending on the task']],
        ['type' => 'text', 'question' => 'Describe a project or achievement you\'re most proud of. What did you do and why does it matter to you?'],
        ['type' => 'choice', 'question' => 'What matters most to you in a career?', 'options' => ['High earning potential', 'Work-life balance', 'Making a positive impact', 'Continuous learning', 'Job security']],
        ['type' => 'text', 'question' => 'If you could do any job for one year with guaranteed success, what would it be and why?'],
    ];

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * AI Counselor Dashboard - module selection
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get recent sessions for this user
        $sessions = AiSession::where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        // Get completed reports
        $completedReports = AiSession::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        return view('ai-counselor.index', compact('sessions', 'completedReports'));
    }

    /**
     * Start a new AI session
     */
    public function startSession(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        if (!Auth::user()->is_paid) {
            return redirect()->route('profile.edit')
                ->with('error', 'Upgrade to Premium to access the AI Career Counselor.');
        }

        $request->validate([
            'module' => 'required|in:career_assessment,interview_prep',
            'target_role' => 'nullable|string|max:100', // For interview prep
        ]);

        $user = Auth::user();
        $module = $request->module;

        // Determine total steps based on module
        $totalSteps = match($module) {
            'career_assessment' => count($this->careerAssessmentQuestions),
            'interview_prep' => 11, // 10 questions + final report
            default => 5,
        };

        // Build context from user profile
        $context = [
            'user_name' => $user->name,
            'skills' => $user->skills ?? [],
            'experience_level' => $user->experience_level,
            'field_of_study' => $user->field_of_study,
            'target_role' => $request->target_role,
        ];

        $session = AiSession::create([
            'user_id' => $user->id,
            'module' => $module,
            'status' => 'in_progress',
            'current_step' => 0,
            'total_steps' => $totalSteps,
            'context_data' => $context,
        ]);

        return redirect()->route('ai-counselor.session', $session);
    }

    /**
     * Show the session wizard page
     */
    public function showSession(AiSession $session)
    {
        $this->authorize('view', $session);

        // If session is complete, show the report
        if ($session->status === 'completed') {
            return view('ai-counselor.report', compact('session'));
        }

        // Special handling for interview prep: generate first question if needed
        if ($session->module === 'interview_prep' && $session->current_step === 0 && $session->steps->isEmpty()) {
            $questionData = $this->gemini->generateInterviewQuestion(
                $session->context_data['target_role'] ?? 'General',
                1
            );

            AiSessionStep::create([
                'session_id' => $session->id,
                'step_number' => 1,
                'step_type' => 'interview_question',
                'prompt' => $questionData['question'] ?? 'Tell me about yourself.',
                'metadata' => $questionData,
            ]);

            $session->current_step = 1;
            $session->save();
            
            // Refresh the session to get the new step
            $session->refresh();
        }

        // Get the current step data
        $stepData = $this->getStepData($session);

        return view('ai-counselor.session', compact('session', 'stepData'));
    }

    /**
     * Submit an answer for the current step
     */
    public function submitStep(Request $request, AiSession $session)
    {
        $this->authorize('update', $session);

        if ($session->status === 'completed') {
            return redirect()->route('ai-counselor.report', $session);
        }

        $module = $session->module;

        // Handle based on module type
        return match($module) {
            'career_assessment' => $this->handleCareerAssessmentStep($request, $session),
            'interview_prep' => $this->handleInterviewPrepStep($request, $session),
            default => back()->with('error', 'Unknown module.'),
        };
    }

    /**
     * Show the final report
     */
    public function showReport(AiSession $session)
    {
        $this->authorize('view', $session);

        if ($session->status !== 'completed') {
            return redirect()->route('ai-counselor.session', $session);
        }

        return view('ai-counselor.report', compact('session'));
    }

    // =============================================
    // CAREER ASSESSMENT HANDLERS
    // =============================================

    protected function handleCareerAssessmentStep(Request $request, AiSession $session): \Illuminate\Http\RedirectResponse
    {
        $currentStep = $session->current_step;
        $questions = $this->careerAssessmentQuestions;

        if ($currentStep >= count($questions)) {
            // Generate final report
            return $this->generateCareerAssessmentReport($session);
        }

        $question = $questions[$currentStep];
        $request->validate(['answer' => 'required|string']);

        // Save the step
        AiSessionStep::create([
            'session_id' => $session->id,
            'step_number' => $currentStep + 1,
            'step_type' => 'question',
            'prompt' => $question['question'],
            'response' => $request->answer,
        ]);

        // Advance step
        $session->current_step = $currentStep + 1;
        $session->save();

        // Check if all questions answered
        if ($session->current_step >= count($questions)) {
            return $this->generateCareerAssessmentReport($session);
        }

        return redirect()->route('ai-counselor.session', $session);
    }

    protected function generateCareerAssessmentReport(AiSession $session): \Illuminate\Http\RedirectResponse
    {
        // Gather all answers
        $answers = $session->steps->map(fn($s) => [
            'question' => $s->prompt,
            'answer' => $s->response,
        ])->toArray();

        // Call AI
        $report = $this->gemini->generateCareerAssessment($session->context_data ?? [], $answers);

        // Save report
        $session->report_data = $report;
        $session->status = 'completed';
        $session->save();

        return redirect()->route('ai-counselor.report', $session);
    }

    // =============================================
    // INTERVIEW PREP HANDLERS
    // =============================================

    protected function handleInterviewPrepStep(Request $request, AiSession $session): \Illuminate\Http\RedirectResponse
    {
        $currentStep = $session->current_step;
        $totalQuestions = 10; // Increased to 10 interview questions

        // User is submitting an answer
        $request->validate(['answer' => 'required|string|min:20']);

        $latestStep = $session->latestStep();
        
        if (!$latestStep) {
            return back()->with('error', 'No question found. Please try again.');
        }
        
        // Evaluate the answer
        try {
            $evaluation = $this->gemini->evaluateInterviewAnswer(
                $session->context_data['target_role'] ?? 'General',
                $latestStep->prompt,
                $request->answer,
                $latestStep->metadata['ideal_answer_points'] ?? []
            );
        } catch (\Exception $e) {
            Log::error('Interview answer evaluation failed', [
                'session_id' => $session->id,
                'error' => $e->getMessage(),
            ]);
            // Provide fallback evaluation
            $evaluation = [
                'score' => 7,
                'feedback' => 'Thank you for your answer. Your response shows good understanding.',
            ];
        }

        // Update the step with the user's answer and AI feedback
        $latestStep->response = $request->answer;
        $latestStep->metadata = array_merge($latestStep->metadata ?? [], ['evaluation' => $evaluation]);
        $latestStep->save();

        // Check if we've completed all questions
        if ($latestStep->step_number >= $totalQuestions) {
            return $this->generateInterviewReport($session);
        }

        // Calculate next question number (should be current + 1)
        $nextQuestionNum = $latestStep->step_number + 1;

        // Get previous Q&A for context
        $previousQA = $session->steps->map(fn($s) => ['question' => $s->prompt])->toArray();

        // Generate next question
        try {
            $questionData = $this->gemini->generateInterviewQuestion(
                $session->context_data['target_role'] ?? 'General',
                $nextQuestionNum,
                $previousQA
            );
        } catch (\Exception $e) {
            Log::error('Interview question generation failed', [
                'session_id' => $session->id,
                'question_number' => $nextQuestionNum,
                'error' => $e->getMessage(),
            ]);
            // Provide fallback question
            $questionData = [
                'question' => 'Tell me about a challenging situation you faced and how you handled it.',
                'question_type' => 'behavioral',
            ];
        }

        AiSessionStep::create([
            'session_id' => $session->id,
            'step_number' => $nextQuestionNum,
            'step_type' => 'interview_question',
            'prompt' => $questionData['question'] ?? 'Tell me about a challenging situation.',
            'metadata' => $questionData,
        ]);

        // Update current_step to match the new question number
        $session->current_step = $nextQuestionNum;
        $session->save();

        return redirect()->route('ai-counselor.session', $session);
    }

    protected function generateInterviewReport(AiSession $session): \Illuminate\Http\RedirectResponse
    {
        $questionsAndScores = $session->steps->map(fn($s) => [
            'question' => $s->prompt,
            'answer' => $s->response,
            'score' => $s->metadata['evaluation']['score'] ?? 0,
            'feedback' => $s->metadata['evaluation']['feedback'] ?? '',
        ])->toArray();

        $report = $this->gemini->generateInterviewReport(
            $session->context_data['target_role'] ?? 'General',
            $questionsAndScores
        );

        $session->report_data = $report;
        $session->status = 'completed';
        $session->save();

        return redirect()->route('ai-counselor.report', $session);
    }

    // =============================================
    // HELPERS
    // =============================================

    protected function getStepData(AiSession $session): array
    {
        $module = $session->module;
        $currentStep = $session->current_step;

        if ($module === 'career_assessment') {
            if ($currentStep < count($this->careerAssessmentQuestions)) {
                return $this->careerAssessmentQuestions[$currentStep];
            }
            return ['type' => 'generating', 'message' => 'Generating your Career DNA report...'];
        }

        if ($module === 'interview_prep') {
            $latestStep = $session->latestStep();
            if ($latestStep && empty($latestStep->response)) {
                // User needs to answer this question
                return [
                    'type' => 'interview_answer',
                    'question' => $latestStep->prompt,
                    'question_type' => $latestStep->metadata['question_type'] ?? 'behavioral',
                    'question_number' => $latestStep->step_number,
                    'previous_feedback' => $session->hasMany(AiSessionStep::class, 'session_id')
                        ->where('step_number', '<', $latestStep->step_number)
                        ->orderByDesc('step_number')
                        ->first()?->metadata['evaluation'] ?? null,
                ];
            }
            return ['type' => 'loading', 'message' => 'Preparing next question...'];
        }

        return [];
    }
}
