<?php

namespace App\Http\Controllers;

use App\Models\CareerPathway;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareerPlanningController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function index()
    {
        $user = Auth::user();
        $existingPathways = $user->careerPathways()->latest()->get();
        
        return view('career-planning.index', compact('existingPathways'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'strengths' => 'required|string',
            'values' => 'required|string',
            'interests' => 'required|string',
            'short_term_goal' => 'required|string',
            'long_term_goal' => 'required|string',
            'skills_gap' => 'nullable|string',
            'experience_gap' => 'nullable|string',
            'action_1' => 'nullable|string',
            'action_2' => 'nullable|string',
            'action_3' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Prepare user profile for AI
        $userProfile = [
            'name' => $user->name,
            'university' => $user->university,
            'field_of_study' => $user->field_of_study,
            'graduation_year' => $user->graduation_year,
            'skills' => $user->skills,
            'experience_level' => $user->experience_level,
            'location' => $user->location,
        ];

        // Prepare workbook data
        $workbookData = [
            'strengths' => $request->strengths,
            'values' => $request->values,
            'interests' => $request->interests,
            'short_term_goal' => $request->short_term_goal,
            'long_term_goal' => $request->long_term_goal,
            'skills_gap' => $request->skills_gap,
            'experience_gap' => $request->experience_gap,
            'actions' => array_filter([
                $request->action_1,
                $request->action_2,
                $request->action_3,
            ]),
        ];

        // Generate AI-powered career pathway
        $aiAnalysis = $this->gemini->generateCareerPlan($userProfile, $workbookData);

        // Parse the AI response to extract structured data
        $parsedData = $this->parseAiResponse($aiAnalysis);

        // Prepare pathway data as JSON
        $pathwayData = [
            'workbook_responses' => $workbookData,
            'ai_analysis' => $aiAnalysis,
            'milestones' => $parsedData['milestones'],
            'skills_required' => $parsedData['skills_required'],
            'resources' => $parsedData['resources'],
            'timeline_years' => $this->extractTimelineYears($request->long_term_goal),
            'generated_at' => now()->toDateTimeString(),
        ];

        // Save career pathway to database
        $pathway = $user->careerPathways()->create([
            'target_role' => $request->long_term_goal,
            'current_role' => $user->experience_level ?? 'Entry Level',
            'pathway_data' => $pathwayData,
            'progress_percentage' => 0,
            'status' => 'active',
            'ai_generated_at' => now(),
        ]);

        return redirect()->route('pathways.show', $pathway)
            ->with('success', 'Your AI-powered career plan has been generated!');
    }

    /**
     * Parse AI response to extract structured data
     */
    protected function parseAiResponse(string $aiResponse): array
    {
        $milestones = [];
        $skills = [];
        $resources = [];

        // Extract milestones (look for numbered lists or bullet points)
        if (preg_match_all('/(?:^|\n)[\d\-\*]+[\.\)]\s*(.+?)(?=\n[\d\-\*]+[\.\)]|\n\n|$)/s', $aiResponse, $matches)) {
            $milestones = array_slice(array_map('trim', $matches[1]), 0, 10);
        }

        // Extract skills (look for skill-related keywords)
        if (preg_match_all('/(?:skill|learn|master|develop|acquire):\s*([^\n]+)/i', $aiResponse, $matches)) {
            $skills = array_map('trim', $matches[1]);
        }

        // If no skills found, extract from common patterns
        if (empty($skills)) {
            if (preg_match_all('/(?:Python|JavaScript|Java|SQL|React|Node\.js|AWS|Azure|Leadership|Communication|Project Management|Data Analysis|Machine Learning|UI\/UX|Marketing|Sales)/i', $aiResponse, $matches)) {
                $skills = array_unique(array_map('trim', $matches[0]));
            }
        }

        // Extract resources (look for resource-related keywords)
        if (preg_match_all('/(?:course|certification|book|platform|resource):\s*([^\n]+)/i', $aiResponse, $matches)) {
            $resources = array_map('trim', $matches[1]);
        }

        return [
            'milestones' => !empty($milestones) ? $milestones : ['Complete self-assessment', 'Identify skill gaps', 'Create action plan'],
            'skills_required' => !empty($skills) ? array_slice($skills, 0, 10) : ['Communication', 'Problem Solving', 'Technical Skills'],
            'resources' => !empty($resources) ? $resources : ['Online courses', 'Industry certifications', 'Networking events'],
        ];
    }

    /**
     * Extract timeline in years from goal description
     */
    protected function extractTimelineYears(string $goal): int
    {
        // Look for year mentions in the goal
        if (preg_match('/(\d+)\s*(?:year|yr)/i', $goal, $matches)) {
            return (int) $matches[1];
        }

        // Default to 3 years for long-term goals
        return 3;
    }
}
