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
        ]);

        $user = Auth::user();

        // Prepare current skills array
        $currentSkills = [];
        if ($user->skills) {
            $currentSkills = array_map('trim', explode(',', $user->skills));
        }
        
        // Add field of study as a skill if available
        if ($user->field_of_study) {
            $currentSkills[] = $user->field_of_study;
        }
        
        // If no skills, use generic entry-level skills
        if (empty($currentSkills)) {
            $currentSkills = ['Communication', 'Teamwork', 'Problem Solving'];
        }

        $experienceLevel = $request->current_role ?? $user->experience_level ?? 'Entry Level';

        try {
            // Generate pathway using AI
            $aiPathwayData = $this->gemini->generateCareerPathway(
                $request->target_role,
                $currentSkills,
                $experienceLevel
            );
        } catch (\Exception $e) {
            \Log::error('Career Pathway AI Generation Failed', [
                'error' => $e->getMessage(),
                'target_role' => $request->target_role,
                'skills' => $currentSkills,
                'experience' => $experienceLevel,
            ]);
            
            return back()->withErrors([
                'ai_error' => 'Unable to generate career pathway. Please try again. If the issue persists, contact support.'
            ])->withInput();
        }

        // Check if AI returned valid data
        if (empty($aiPathwayData) || !is_array($aiPathwayData)) {
            \Log::error('Career Pathway AI returned empty or invalid data', [
                'response' => $aiPathwayData,
                'target_role' => $request->target_role,
            ]);
            
            // Use fallback pathway instead of failing
            $aiPathwayData = $this->createFallbackPathway($request->target_role, $currentSkills, $experienceLevel);
        }

        // Format pathway data for storage
        $pathwayData = [
            'title' => $aiPathwayData['title'] ?? "Path to {$request->target_role}",
            'description' => $aiPathwayData['description'] ?? '',
            'duration_months' => $aiPathwayData['duration_months'] ?? 12,
            'milestones' => $aiPathwayData['milestones'] ?? [],
            'skills_required' => $aiPathwayData['required_skills'] ?? [],
            'resources' => $aiPathwayData['recommended_resources'] ?? [],
            'timeline_years' => isset($aiPathwayData['duration_months']) ? ceil($aiPathwayData['duration_months'] / 12) : 1,
            'generated_at' => now()->toDateTimeString(),
            'ai_analysis' => $aiPathwayData['description'] ?? "Your personalized pathway to becoming a {$request->target_role}.",
        ];

        // Create pathway record
        $pathway = $user->careerPathways()->create([
            'current_role' => $experienceLevel,
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

    /**
     * Create a fallback pathway when AI fails
     */
    protected function createFallbackPathway(string $targetRole, array $currentSkills, string $experienceLevel): array
    {
        // Role-specific data
        $roleData = $this->getRoleSpecificData($targetRole);
        
        return [
            'title' => "Career Path to {$targetRole}",
            'description' => "A structured pathway to help you transition from {$experienceLevel} to {$targetRole}. This plan combines your current skills (" . implode(', ', array_slice($currentSkills, 0, 3)) . ") with industry-standard requirements to create a personalized roadmap for success.",
            'duration_months' => $roleData['duration'],
            'milestones' => $roleData['milestones'],
            'required_skills' => array_merge($currentSkills, $roleData['skills']),
            'recommended_resources' => $roleData['resources']
        ];
    }
    
    /**
     * Get role-specific pathway data
     */
    protected function getRoleSpecificData(string $targetRole): array
    {
        $roleLower = strtolower($targetRole);
        
        // Software Engineer pathway
        if (strpos($roleLower, 'software') !== false || strpos($roleLower, 'developer') !== false || strpos($roleLower, 'engineer') !== false) {
            return [
                'duration' => 18,
                'milestones' => [
                    [
                        'title' => 'Master Core Programming Fundamentals',
                        'description' => 'Build a strong foundation in data structures, algorithms, and object-oriented programming. Practice coding daily on platforms like LeetCode and HackerRank.',
                        'duration_weeks' => 12,
                        'skills_gained' => ['Data Structures', 'Algorithms', 'OOP Principles', 'Problem Solving', 'Code Optimization']
                    ],
                    [
                        'title' => 'Learn Modern Web Technologies',
                        'description' => 'Master frontend frameworks (React/Vue), backend development (Node.js/Laravel), and database management (SQL/NoSQL). Build 3-5 full-stack projects.',
                        'duration_weeks' => 16,
                        'skills_gained' => ['React/Vue.js', 'RESTful APIs', 'Database Design', 'Git Version Control', 'Responsive Design']
                    ],
                    [
                        'title' => 'Build Production-Ready Projects',
                        'description' => 'Create a portfolio of 3-5 complex applications with proper testing, CI/CD pipelines, and deployment. Focus on code quality and best practices.',
                        'duration_weeks' => 14,
                        'skills_gained' => ['Testing (Jest/PHPUnit)', 'CI/CD', 'Docker', 'Cloud Deployment (AWS/Azure)', 'Code Review']
                    ],
                    [
                        'title' => 'Contribute to Open Source & Network',
                        'description' => 'Make meaningful contributions to open-source projects on GitHub. Attend tech meetups, conferences, and build your professional network.',
                        'duration_weeks' => 10,
                        'skills_gained' => ['Open Source Contribution', 'Technical Writing', 'Code Collaboration', 'Networking', 'Community Engagement']
                    ],
                    [
                        'title' => 'Interview Preparation & Job Search',
                        'description' => 'Practice system design, behavioral interviews, and technical coding challenges. Apply to 50+ positions and leverage your network for referrals.',
                        'duration_weeks' => 8,
                        'skills_gained' => ['System Design', 'Interview Skills', 'Resume Optimization', 'Salary Negotiation', 'Professional Branding']
                    ]
                ],
                'skills' => ['JavaScript/TypeScript', 'Python/PHP', 'React/Vue', 'Node.js', 'SQL/NoSQL', 'Git', 'Agile/Scrum', 'Testing', 'Cloud Services'],
                'resources' => [
                    [
                        'type' => 'course',
                        'title' => 'The Complete Web Developer Bootcamp (Udemy)',
                        'description' => 'Comprehensive course covering HTML, CSS, JavaScript, React, Node.js, and databases with hands-on projects'
                    ],
                    [
                        'type' => 'book',
                        'title' => 'Clean Code by Robert C. Martin',
                        'description' => 'Essential reading for writing maintainable, professional-quality code that follows industry best practices'
                    ],
                    [
                        'type' => 'course',
                        'title' => 'LeetCode Premium Subscription',
                        'description' => 'Practice 200+ coding problems to prepare for technical interviews at top tech companies'
                    ],
                    [
                        'type' => 'certification',
                        'title' => 'AWS Certified Developer Associate',
                        'description' => 'Industry-recognized certification demonstrating cloud development expertise on Amazon Web Services'
                    ]
                ]
            ];
        }
        
        // Data Analyst/Scientist pathway
        if (strpos($roleLower, 'data') !== false || strpos($roleLower, 'analyst') !== false || strpos($roleLower, 'scientist') !== false) {
            return [
                'duration' => 16,
                'milestones' => [
                    [
                        'title' => 'Master Statistics & Python for Data Analysis',
                        'description' => 'Learn statistical concepts, probability, and Python libraries (Pandas, NumPy, Matplotlib). Complete 10+ data analysis projects.',
                        'duration_weeks' => 12,
                        'skills_gained' => ['Python Programming', 'Pandas & NumPy', 'Statistical Analysis', 'Data Visualization', 'Jupyter Notebooks']
                    ],
                    [
                        'title' => 'SQL & Database Management',
                        'description' => 'Master SQL queries, database design, and data warehousing. Work with real datasets from Kaggle and public APIs.',
                        'duration_weeks' => 10,
                        'skills_gained' => ['Advanced SQL', 'Database Design', 'ETL Processes', 'Data Warehousing', 'Query Optimization']
                    ],
                    [
                        'title' => 'Machine Learning & Predictive Modeling',
                        'description' => 'Learn ML algorithms, model training, and evaluation. Build predictive models using scikit-learn and TensorFlow.',
                        'duration_weeks' => 14,
                        'skills_gained' => ['Machine Learning', 'Scikit-learn', 'Model Evaluation', 'Feature Engineering', 'Predictive Analytics']
                    ],
                    [
                        'title' => 'Business Intelligence & Visualization',
                        'description' => 'Master Tableau/Power BI for creating interactive dashboards. Learn to communicate insights to stakeholders effectively.',
                        'duration_weeks' => 10,
                        'skills_gained' => ['Tableau/Power BI', 'Dashboard Design', 'Data Storytelling', 'Business Metrics', 'Stakeholder Communication']
                    ],
                    [
                        'title' => 'Portfolio & Job Application',
                        'description' => 'Create a portfolio website showcasing 5+ data projects. Network with data professionals and apply to positions.',
                        'duration_weeks' => 8,
                        'skills_gained' => ['Portfolio Development', 'GitHub Projects', 'Technical Presentation', 'Interview Prep', 'Networking']
                    ]
                ],
                'skills' => ['Python', 'SQL', 'Statistics', 'Machine Learning', 'Tableau/Power BI', 'Excel', 'R Programming', 'Data Cleaning', 'A/B Testing'],
                'resources' => [
                    [
                        'type' => 'course',
                        'title' => 'Python for Data Science and Machine Learning (Udemy)',
                        'description' => 'Complete bootcamp covering Python, Pandas, NumPy, Matplotlib, Seaborn, Scikit-Learn, and TensorFlow'
                    ],
                    [
                        'type' => 'book',
                        'title' => 'Practical Statistics for Data Scientists by Bruce & Bruce',
                        'description' => 'Essential statistical concepts explained with practical examples for data science applications'
                    ],
                    [
                        'type' => 'certification',
                        'title' => 'Google Data Analytics Professional Certificate',
                        'description' => 'Industry-recognized certification covering data analysis, SQL, R, and Tableau'
                    ],
                    [
                        'type' => 'course',
                        'title' => 'Kaggle Learn Courses (Free)',
                        'description' => 'Hands-on micro-courses in Python, ML, SQL, and data visualization with real datasets'
                    ]
                ]
            ];
        }
        
        // Generic pathway for other roles
        return [
            'duration' => 18,
            'milestones' => [
                [
                    'title' => 'Foundation: Core Skills Development',
                    'description' => "Master the fundamental skills required for {$targetRole}. Take online courses, read industry books, and practice daily.",
                    'duration_weeks' => 12,
                    'skills_gained' => ['Industry Fundamentals', 'Technical Skills', 'Best Practices', 'Tool Proficiency', 'Problem Solving']
                ],
                [
                    'title' => 'Intermediate: Hands-On Experience',
                    'description' => 'Build 3-5 portfolio projects demonstrating your capabilities. Contribute to real-world projects or freelance work.',
                    'duration_weeks' => 16,
                    'skills_gained' => ['Project Management', 'Practical Application', 'Portfolio Building', 'Client Communication', 'Quality Assurance']
                ],
                [
                    'title' => 'Advanced: Specialization & Expertise',
                    'description' => "Develop deep expertise in your chosen specialization within {$targetRole}. Stay current with industry trends and innovations.",
                    'duration_weeks' => 14,
                    'skills_gained' => ['Advanced Techniques', 'Industry Trends', 'Specialized Knowledge', 'Innovation', 'Thought Leadership']
                ],
                [
                    'title' => 'Professional: Network & Brand Building',
                    'description' => 'Build your professional network through conferences, meetups, and online communities. Establish your personal brand.',
                    'duration_weeks' => 10,
                    'skills_gained' => ['Networking', 'Personal Branding', 'Public Speaking', 'Content Creation', 'Community Engagement']
                ],
                [
                    'title' => 'Career Transition: Job Search & Interviews',
                    'description' => 'Optimize your resume and LinkedIn profile. Apply strategically and prepare thoroughly for interviews.',
                    'duration_weeks' => 8,
                    'skills_gained' => ['Resume Writing', 'Interview Skills', 'Salary Negotiation', 'Job Search Strategy', 'Professional Presentation']
                ]
            ],
            'skills' => ['Communication', 'Leadership', 'Technical Proficiency', 'Problem Solving', 'Adaptability', 'Time Management', 'Collaboration', 'Critical Thinking'],
            'resources' => [
                [
                    'type' => 'course',
                    'title' => "Professional Development for {$targetRole} (Coursera/Udemy)",
                    'description' => 'Comprehensive online courses covering essential skills and industry best practices'
                ],
                [
                    'type' => 'book',
                    'title' => "Industry-Specific Books for {$targetRole}",
                    'description' => 'Read top-rated books recommended by professionals in your target field'
                ],
                [
                    'type' => 'certification',
                    'title' => "Professional Certification for {$targetRole}",
                    'description' => 'Obtain industry-recognized certifications to validate your expertise and stand out'
                ],
                [
                    'type' => 'course',
                    'title' => 'LinkedIn Learning Subscription',
                    'description' => 'Access thousands of courses on technical skills, soft skills, and industry-specific topics'
                ]
            ]
        ];
    }
}
