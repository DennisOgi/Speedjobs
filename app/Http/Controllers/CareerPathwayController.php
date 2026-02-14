<?php

namespace App\Http\Controllers;

use App\Models\CareerPathway;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareerPathwayController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show career pathways dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $pathways = $user->careerPathways()
            ->latest('ai_generated_at')
            ->paginate(10);

        $currentPathway = $user->careerPathways()->active()->latest()->first();

        $stats = [
            'total' => $user->careerPathways()->count(),
            'active' => $user->careerPathways()->active()->count(),
            'completed' => $user->careerPathways()->completed()->count(),
            'avg_progress' => $user->careerPathways()->active()->avg('progress_percentage') ?? 0,
        ];

        return view('pathways.index', compact('pathways', 'currentPathway', 'stats'));
    }

    /**
     * Show create pathway form
     */
    public function create()
    {
        return view('pathways.create');
    }

    /**
     * Generate and store career pathway
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_role' => 'required|string|max:255',
            'current_role' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();

        // Get user profile for context
        $userProfile = [
            'name' => $user->name,
            'university' => $user->university,
            'field_of_study' => $user->field_of_study,
            'graduation_year' => $user->graduation_year,
            'skills' => $user->skills,
            'experience_level' => $user->experience_level,
            'location' => $user->location,
        ];

        // Generate pathway using AI
        $pathwayData = $this->gemini->generateCareerPathway(
            $request->target_role,
            $userProfile,
            $request->current_role
        );

        // Create pathway record
        $pathway = $user->careerPathways()->create([
            'current_role' => $request->current_role ?? 'Student/Entry Level',
            'target_role' => $request->target_role,
            'pathway_data' => $pathwayData,
            'progress_percentage' => 0,
            'status' => 'active',
            'ai_generated_at' => now(),
            'last_updated_at' => now(),
        ]);

        return redirect()->route('pathways.show', $pathway)
            ->with('success', 'Career pathway generated successfully!');
    }

    /**
     * Show specific pathway
     */
    public function show(CareerPathway $pathway)
    {
        $this->authorize('view', $pathway);

        return view('pathways.show', compact('pathway'));
    }

    /**
     * Update pathway progress
     */
    public function updateProgress(Request $request, CareerPathway $pathway)
    {
        $this->authorize('update', $pathway);

        $request->validate([
            'step_index' => 'required|integer|min:0',
            'completed' => 'required|boolean',
        ]);

        $pathwayData = $pathway->pathway_data;
        $stepIndex = $request->step_index;

        // Update step completion status
        if (isset($pathwayData['steps'][$stepIndex])) {
            if (!isset($pathwayData['completed_steps'])) {
                $pathwayData['completed_steps'] = [];
            }

            if ($request->completed) {
                $pathwayData['completed_steps'][] = $stepIndex;
            } else {
                $pathwayData['completed_steps'] = array_diff(
                    $pathwayData['completed_steps'],
                    [$stepIndex]
                );
            }

            // Calculate progress percentage
            $totalSteps = count($pathwayData['steps']);
            $completedSteps = count($pathwayData['completed_steps']);
            $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

            // Update pathway
            $pathway->update([
                'pathway_data' => $pathwayData,
                'progress_percentage' => $progress,
                'status' => $progress >= 100 ? 'completed' : 'active',
                'last_updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'progress' => $progress,
                'status' => $pathway->status,
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    /**
     * Delete pathway
     */
    public function destroy(CareerPathway $pathway)
    {
        $this->authorize('delete', $pathway);

        $pathway->delete();

        return redirect()->route('pathways.index')
            ->with('success', 'Career pathway deleted successfully');
    }
}
