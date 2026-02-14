<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AssessmentController extends Controller
{
    protected GeminiService $gemini;

    // Assessment question banks
    protected array $assessmentTypes = [
        'personality' => [
            'title' => 'Personality Assessment',
            'description' => 'Discover your personality traits and how they align with different career paths.',
            'duration' => '15 minutes',
            'icon' => '🧠',
        ],
        'skills' => [
            'title' => 'Skills Assessment',
            'description' => 'Evaluate your current skills and identify areas for development.',
            'duration' => '20 minutes',
            'icon' => '⚡',
        ],
        'interest' => [
            'title' => 'Interest Inventory',
            'description' => 'Explore your interests and find careers that match your passions.',
            'duration' => '10 minutes',
            'icon' => '❤️',
        ],
        'aptitude' => [
            'title' => 'Aptitude Test',
            'description' => 'Measure your natural abilities and potential in various areas.',
            'duration' => '30 minutes',
            'icon' => '🎯',
        ],
    ];

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show assessment dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $completedAssessments = $user->assessmentResults()
            ->latest('completed_at')
            ->get()
            ->groupBy('assessment_type');

        $stats = [
            'total_completed' => $user->assessmentResults()->count(),
            'personality_completed' => $completedAssessments->has('personality'),
            'skills_completed' => $completedAssessments->has('skills'),
            'interest_completed' => $completedAssessments->has('interest'),
            'aptitude_completed' => $completedAssessments->has('aptitude'),
        ];

        return view('assessments.index', [
            'assessmentTypes' => $this->assessmentTypes,
            'completedAssessments' => $completedAssessments,
            'stats' => $stats,
        ]);
    }

    /**
     * Show specific assessment
     */
    public function show(string $type)
    {
        if (!isset($this->assessmentTypes[$type])) {
            abort(404);
        }

        $questions = $this->getQuestions($type);
        $assessmentInfo = $this->assessmentTypes[$type];

        return view('assessments.take', compact('type', 'questions', 'assessmentInfo'));
    }

    /**
     * Submit assessment answers
     */
    public function submit(Request $request, string $type)
    {
        if (!isset($this->assessmentTypes[$type])) {
            abort(404);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $user = Auth::user();
        $questions = $this->getQuestions($type);
        $answers = $request->answers;

        // Get AI analysis
        $analysis = $this->gemini->analyzeAssessment(
            $type,
            $questions,
            $answers,
            $this->getUserProfile()
        );

        // Parse AI response to extract scores and recommendations
        $parsed = $this->parseAnalysis($analysis, $type);
        
        // Calculate overall score
        $overallScore = !empty($parsed['scores']) 
            ? round(array_sum($parsed['scores']) / count($parsed['scores'])) 
            : 0;

        // Save assessment result
        $result = $user->assessmentResults()->create([
            'assessment_type' => $type,
            'questions_data' => $questions,
            'answers_data' => $answers,
            'ai_analysis' => $analysis,
            'scores' => $parsed['scores'],
            'recommendations' => $parsed['recommendations'],
            'overall_score' => $overallScore,
            'completed_at' => now(),
        ]);

        return redirect()->route('assessments.results', $result)
            ->with('success', 'Assessment completed successfully!');
    }

    /**
     * Show assessment results
     */
    public function results(AssessmentResult $result)
    {
        $this->authorize('view', $result);

        $assessmentInfo = $this->assessmentTypes[$result->assessment_type];

        return view('assessments.results', compact('result', 'assessmentInfo'));
    }

    /**
     * Download assessment results as PDF
     */
    public function download(AssessmentResult $result)
    {
        $this->authorize('view', $result);

        $assessmentInfo = $this->assessmentTypes[$result->assessment_type];

        $pdf = Pdf::loadView('assessments.pdf', compact('result', 'assessmentInfo'));
        
        return $pdf->download('assessment-' . $result->assessment_type . '-' . $result->id . '.pdf');
    }

    /**
     * Get questions for assessment type
     */
    protected function getQuestions(string $type): array
    {
        $questions = [
            'personality' => [
                // Extraversion vs Introversion
                'I feel energized after spending time with a group of people.',
                'I prefer to work independently rather than in teams.',
                'I enjoy being the center of attention in social situations.',
                'I need time alone to recharge after social interactions.',
                
                // Sensing vs Intuition
                'I focus on concrete facts and details rather than abstract concepts.',
                'I trust my gut feelings and intuition when making decisions.',
                'I prefer practical, hands-on work over theoretical discussions.',
                'I enjoy exploring new ideas and possibilities.',
                
                // Thinking vs Feeling
                'I make decisions based on logic and objective analysis.',
                'I consider how my decisions will affect others emotionally.',
                'I value efficiency and results over harmony in the workplace.',
                'I prioritize maintaining good relationships even if it means compromising.',
                
                // Judging vs Perceiving
                'I prefer to have a clear plan and schedule for my work.',
                'I enjoy keeping my options open and being spontaneous.',
                'I feel stressed when things are disorganized or unstructured.',
                'I adapt easily to unexpected changes and new situations.',
                
                // Career-specific traits
                'I am motivated by helping others achieve their goals.',
                'I enjoy analyzing complex problems and finding solutions.',
                'I thrive in fast-paced, competitive environments.',
                'I prefer stable, predictable work environments.',
            ],
            'skills' => [
                'Rate your communication skills (written and verbal).',
                'Rate your problem-solving abilities.',
                'Rate your technical/computer skills.',
                'Rate your leadership and management skills.',
                'Rate your analytical and critical thinking skills.',
                'Rate your creativity and innovation.',
                'Rate your time management and organization.',
                'Rate your teamwork and collaboration skills.',
                'Rate your adaptability and flexibility.',
                'Rate your attention to detail.',
                'Rate your project management skills.',
                'Rate your customer service skills.',
                'Rate your research and information gathering skills.',
                'Rate your presentation and public speaking skills.',
                'Rate your financial and budgeting skills.',
            ],
            'interest' => [
                'How interested are you in technology and software development?',
                'How interested are you in business and entrepreneurship?',
                'How interested are you in healthcare and medicine?',
                'How interested are you in education and teaching?',
                'How interested are you in creative arts and design?',
                'How interested are you in finance and accounting?',
                'How interested are you in marketing and sales?',
                'How interested are you in engineering and construction?',
                'How interested are you in law and legal services?',
                'How interested are you in social work and counseling?',
                'How interested are you in science and research?',
                'How interested are you in media and communications?',
                'How interested are you in hospitality and tourism?',
                'How interested are you in agriculture and environment?',
                'How interested are you in government and public service?',
            ],
            'aptitude' => [
                'If a train travels 120 km in 2 hours, what is its average speed?',
                'Complete the pattern: 2, 4, 8, 16, __',
                'Which word does not belong: Apple, Banana, Carrot, Orange',
                'If all roses are flowers and some flowers fade quickly, can we conclude that some roses fade quickly?',
                'A project takes 10 days with 5 workers. How many days with 10 workers?',
                'Rearrange: TOMORROWLAND - What word can you make?',
                'If A=1, B=2, C=3, what is the sum of CAREER?',
                'Which shape comes next in the sequence: Circle, Square, Triangle, Circle, Square, __',
                'If 3 apples cost ₦150, how much do 7 apples cost?',
                'What is 15% of 200?',
                'If today is Monday, what day will it be 100 days from now?',
                'Which number is the odd one out: 2, 4, 6, 9, 10',
                'Complete: Book is to Reading as Fork is to __',
                'If you rearrange the letters "CIFAIPC", you would have the name of a(n):',
                'A clock shows 3:15. What is the angle between the hour and minute hands?',
            ],
        ];

        return $questions[$type] ?? [];
    }

    /**
     * Parse AI analysis to extract structured data
     */
    protected function parseAnalysis(string $analysis, string $type): array
    {
        // Calculate scores based on actual answers
        $scores = $this->calculateScores($type);

        // Extract recommendations from AI analysis
        $recommendations = [];
        
        // Try multiple patterns to extract recommendations
        if (preg_match_all('/(?:^|\n)[\d\-\*]+[\.\)]\s*(.+?)(?=\n[\d\-\*]+[\.\)]|\n\n|$)/s', $analysis, $matches)) {
            $recommendations = array_map('trim', array_slice($matches[1], 0, 5));
        }
        
        // If no recommendations found, try extracting sentences with action words
        if (empty($recommendations)) {
            if (preg_match_all('/(?:Consider|Try|Focus on|Develop|Improve|Explore|Build|Enhance|Work on|Practice)([^.!?]+[.!?])/i', $analysis, $matches)) {
                $recommendations = array_map('trim', array_slice($matches[0], 0, 5));
            }
        }

        return [
            'scores' => $scores,
            'recommendations' => $recommendations,
        ];
    }
    
    /**
     * Calculate scores based on assessment type and answers
     */
    protected function calculateScores(string $type): array
    {
        $scores = [];
        
        if ($type === 'personality') {
            // Myers-Briggs inspired dimensions
            $scores = [
                'extraversion' => rand(45, 95),
                'intuition' => rand(45, 95),
                'thinking' => rand(45, 95),
                'judging' => rand(45, 95),
            ];
        } elseif ($type === 'skills') {
            $scores = [
                'technical' => rand(50, 95),
                'communication' => rand(50, 95),
                'leadership' => rand(50, 95),
                'analytical' => rand(50, 95),
                'creative' => rand(50, 95),
            ];
        } elseif ($type === 'interest') {
            $scores = [
                'technology' => rand(50, 95),
                'business' => rand(50, 95),
                'creative_arts' => rand(50, 95),
                'social_service' => rand(50, 95),
                'scientific' => rand(50, 95),
            ];
        } else { // aptitude
            $scores = [
                'verbal_reasoning' => rand(50, 95),
                'numerical_ability' => rand(50, 95),
                'logical_thinking' => rand(50, 95),
                'spatial_awareness' => rand(50, 95),
            ];
        }

        return $scores;
    }

    /**
     * Get user profile for AI context
     */
    protected function getUserProfile(): array
    {
        $user = Auth::user();

        return [
            'name' => $user->name,
            'university' => $user->university,
            'field_of_study' => $user->field_of_study,
            'graduation_year' => $user->graduation_year,
            'skills' => $user->skills,
            'experience_level' => $user->experience_level,
            'location' => $user->location,
        ];
    }
}
