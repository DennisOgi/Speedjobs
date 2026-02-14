<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Get recommended jobs based on user profile
        $recommendedJobs = $this->getRecommendedJobs($user);
        
        return view('profile.edit', [
            'user' => $user,
            'recommendedJobs' => $recommendedJobs,
        ]);
    }
    
    /**
     * Get personalized job recommendations based on user profile with relevance scoring
     */
    private function getRecommendedJobs($user, int $limit = 6): \Illuminate\Support\Collection
    {
        // Get IDs of jobs the user has already applied to (to exclude them)
        $appliedJobIds = $user->jobApplications()->pluck('job_id')->toArray();
        
        // Get all jobs not already applied to
        $jobs = \App\Models\Job::whereNotIn('id', $appliedJobIds)->get();
        
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
            $matchReasons = [];
            $jobTitle = strtolower($job->title);
            $jobDescription = strtolower($job->description ?? '');
            $jobRequirements = strtolower($job->requirements ?? '');
            $jobCategory = strtolower($job->category ?? '');
            $jobLocation = strtolower($job->location ?? '');
            $combinedJobText = $jobTitle . ' ' . $jobDescription . ' ' . $jobRequirements . ' ' . $jobCategory;

            // 1. Skills matching (high weight - 3 points per skill matched)
            $matchedSkills = [];
            foreach ($userSkills as $skill) {
                if ($skill && strlen($skill) > 2 && str_contains($combinedJobText, $skill)) {
                    $score += 3;
                    $matchedSkills[] = ucfirst($skill);
                }
            }
            if (!empty($matchedSkills)) {
                $matchReasons[] = 'Matches your skills: ' . implode(', ', array_slice($matchedSkills, 0, 3));
            }

            // 2. Field of study / Category matching (medium-high weight - 5 points)
            if ($userFieldOfStudy) {
                // Direct field match
                if (str_contains($combinedJobText, $userFieldOfStudy)) {
                    $score += 5;
                    $matchReasons[] = 'Aligns with your field of study';
                }
                
                // Category-based matching using field mapping
                foreach ($fieldToCategories as $field => $keywords) {
                    if (str_contains($userFieldOfStudy, $field)) {
                        foreach ($keywords as $keyword) {
                            if (str_contains($combinedJobText, $keyword)) {
                                $score += 2;
                                if (!in_array('Aligns with your field of study', $matchReasons)) {
                                    $matchReasons[] = 'Related to your field of study';
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
            }

            // 3. Location matching (medium weight - 4 points)
            if ($userLocation) {
                $locationParts = array_map('trim', preg_split('/[,\s]+/', $userLocation));
                foreach ($locationParts as $part) {
                    if (strlen($part) > 2 && str_contains($jobLocation, $part)) {
                        $score += 4;
                        $matchReasons[] = 'Located in your preferred area';
                        break;
                    }
                }
            }

            // 4. Experience level matching (medium weight - 3 points)
            if ($userExperienceLevel) {
                $levelKeywords = [
                    'student' => ['entry', 'junior', 'graduate', 'intern', 'trainee', 'fresh'],
                    'fresh_graduate' => ['entry', 'junior', 'graduate', 'fresh', '0-2'],
                    'entry_level' => ['entry', 'junior', '0-2', '1-2'],
                    'mid_level' => ['mid', 'intermediate', '2-5', '3-5'],
                    'senior_level' => ['senior', 'lead', 'principal', 'manager', 'head', '5+'],
                ];
                
                if (isset($levelKeywords[$userExperienceLevel])) {
                    foreach ($levelKeywords[$userExperienceLevel] as $keyword) {
                        if (str_contains($combinedJobText, $keyword)) {
                            $score += 3;
                            $matchReasons[] = 'Matches your experience level';
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
                $matchReasons[] = 'Recently posted';
            } elseif ($daysOld <= 14) {
                $score += 1;
            }

            $job->relevance_score = $score;
            $job->match_reasons = $matchReasons;
            return $job;
        });

        // Filter to only jobs with some relevance, then sort by score
        $recommendedJobs = $scoredJobs
            ->filter(fn($job) => $job->relevance_score > 0)
            ->sortByDesc('relevance_score')
            ->take($limit)
            ->values();

        return $recommendedJobs;
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
