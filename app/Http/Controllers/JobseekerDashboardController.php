<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobseekerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get IDs of jobs the user has already applied to (to exclude them)
        $appliedJobIds = $user->jobApplications()->pluck('job_id')->toArray();

        // Build personalized job recommendations with relevance scoring
        $recommendedJobs = $this->getRecommendedJobs($user, $appliedJobIds);
        
        // Fallback to latest jobs if no personalized matches
        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = \App\Models\Job::whereNotIn('id', $appliedJobIds)
                ->latest()
                ->take(6)
                ->get();
        }
        
        // Fetch active course enrollments
        $activeEnrollments = $user->courseEnrollments()
            ->with('course')
            ->latest()
            ->take(3)
            ->get();

        // Fetch recent counseling requests
        $counselingRequests = $user->counselingRequests()
            ->with('assignedCounselor.user')
            ->latest()
            ->take(3)
            ->get();

        // Fetch upcoming bookings
        $upcomingBookings = $user->counselorBookings()
            ->with('counselor.user')
            ->where('session_date', '>=', now())
            ->orderBy('session_date')
            ->orderBy('session_time')
            ->take(3)
            ->get();


        // Fetch recent job applications
        $recentApplications = $user->jobApplications()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();

        // Fetch saved jobs
        $savedJobs = $user->savedJobs()
            ->with('job')
            ->latest()
            ->take(5)
            ->get(); 

        // Fetch resources
        $resources = \App\Models\Resource::where('is_active', true)->latest()->get();

        // Fetch workshop registrations
        $workshopRegistrations = $user->workshopRegistrations()
            ->with('workshop')
            ->whereHas('workshop', function($q) {
                $q->where('start_date', '>=', now());
            })
            ->latest()
            ->take(3)
            ->get();

        // Calculate profile completion percentage
        $profileFields = ['name', 'email', 'phone', 'location', 'university', 'field_of_study', 'graduation_year', 'skills', 'experience_level'];
        $completedFields = 0;
        foreach ($profileFields as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }
        $profileCompletion = round(($completedFields / count($profileFields)) * 100);

        return view('dashboard', compact(
            'recommendedJobs', 
            'recentApplications', 
            'savedJobs',
            'activeEnrollments',
            'counselingRequests',
            'upcomingBookings',
            'resources',
            'workshopRegistrations',
            'profileCompletion'
        ));
    }

    /**
     * Get personalized job recommendations based on user profile with relevance scoring
     */
    private function getRecommendedJobs($user, array $excludeJobIds = []): \Illuminate\Support\Collection
    {
        // Get all jobs not already applied to
        $jobs = \App\Models\Job::whereNotIn('id', $excludeJobIds)->get();
        
        if ($jobs->isEmpty()) {
            return collect([]);
        }

        // Prepare user data for matching
        $userSkills = $user->skills ? array_map('trim', array_map('strtolower', explode(',', $user->skills))) : [];
        $userFieldOfStudy = $user->field_of_study ? strtolower($user->field_of_study) : null;
        $userLocation = $user->location ? strtolower($user->location) : null;
        $userExperienceLevel = $user->experience_level ?? null;

        // Map of field of study to related job categories and keywords
        $fieldToCategories = [
            'computer science' => ['technology', 'software', 'developer', 'engineer', 'programming', 'it', 'tech'],
            'engineering' => ['engineering', 'engineer', 'technical', 'infrastructure', 'manufacturing'],
            'business administration' => ['business', 'management', 'marketing', 'sales', 'finance', 'administration'],
            'economics' => ['finance', 'banking', 'economics', 'analyst', 'investment', 'accounting'],
            'law' => ['legal', 'law', 'compliance', 'lawyer', 'attorney', 'paralegal'],
            'medicine' => ['healthcare', 'medical', 'health', 'hospital', 'clinical', 'nursing', 'pharmaceutical'],
            'marketing' => ['marketing', 'advertising', 'digital', 'brand', 'communications', 'social media'],
            'accounting' => ['accounting', 'finance', 'audit', 'tax', 'bookkeeping', 'financial'],
        ];

        // Score each job based on relevance
        $scoredJobs = $jobs->map(function ($job) use ($userSkills, $userFieldOfStudy, $userLocation, $userExperienceLevel, $fieldToCategories) {
            $score = 0;
            $jobTitle = strtolower($job->title);
            $jobDescription = strtolower($job->description ?? '');
            $jobRequirements = strtolower($job->requirements ?? '');
            $jobCategory = strtolower($job->category ?? '');
            $jobLocation = strtolower($job->location ?? '');
            $jobType = strtolower($job->type ?? '');
            $combinedJobText = $jobTitle . ' ' . $jobDescription . ' ' . $jobRequirements . ' ' . $jobCategory;

            // 1. Skills matching (high weight - 3 points per skill matched)
            foreach ($userSkills as $skill) {
                if ($skill && strlen($skill) > 2 && str_contains($combinedJobText, $skill)) {
                    $score += 3;
                }
            }

            // 2. Field of study / Category matching (medium-high weight - 5 points)
            if ($userFieldOfStudy) {
                // Direct field match
                if (str_contains($combinedJobText, $userFieldOfStudy)) {
                    $score += 5;
                }
                
                // Category-based matching using field mapping
                foreach ($fieldToCategories as $field => $keywords) {
                    if (str_contains($userFieldOfStudy, $field)) {
                        foreach ($keywords as $keyword) {
                            if (str_contains($combinedJobText, $keyword)) {
                                $score += 2;
                                break; // Only count once per field match
                            }
                        }
                        break;
                    }
                }
            }

            // 3. Location matching (medium weight - 4 points)
            if ($userLocation) {
                // Extract city/region from user location for partial matching
                $locationParts = array_map('trim', preg_split('/[,\s]+/', $userLocation));
                foreach ($locationParts as $part) {
                    if (strlen($part) > 2 && str_contains($jobLocation, $part)) {
                        $score += 4;
                        break;
                    }
                }
            }

            // 4. Experience level matching (medium weight - 3 points)
            if ($userExperienceLevel) {
                $levelKeywords = [
                    'entry' => ['entry', 'junior', 'graduate', 'intern', 'trainee', 'fresh', '0-2', '0 - 2', '1-2'],
                    'intermediate' => ['mid', 'intermediate', '2-5', '3-5', '2 - 5', '3 - 5'],
                    'senior' => ['senior', 'lead', 'principal', 'manager', 'head', '5+', '5 years+', 'experienced'],
                ];
                
                if (isset($levelKeywords[$userExperienceLevel])) {
                    foreach ($levelKeywords[$userExperienceLevel] as $keyword) {
                        if (str_contains($combinedJobText, $keyword)) {
                            $score += 3;
                            break;
                        }
                    }
                }
            }

            // 5. Boost for featured jobs (small bonus - 1 point)
            if ($job->is_featured) {
                $score += 1;
            }

            // 6. Recency boost - newer jobs get slight advantage
            $daysOld = now()->diffInDays($job->created_at);
            if ($daysOld <= 7) {
                $score += 2;
            } elseif ($daysOld <= 14) {
                $score += 1;
            }

            $job->relevance_score = $score;
            return $job;
        });

        // Filter to only jobs with some relevance, then sort by score
        $recommendedJobs = $scoredJobs
            ->filter(fn($job) => $job->relevance_score > 0)
            ->sortByDesc('relevance_score')
            ->take(6)
            ->values();

        return $recommendedJobs;
    }
}
