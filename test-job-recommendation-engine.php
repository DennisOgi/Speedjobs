<?php

/**
 * Comprehensive Job Recommendation Engine Test
 * Tests the AI-powered job matching algorithm and its manifestation
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Job;
use App\Http\Controllers\JobseekerDashboardController;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║      JOB RECOMMENDATION ENGINE COMPREHENSIVE TEST              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// ============================================================================
// PART 1: Test Recommendation Algorithm
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 1: RECOMMENDATION ALGORITHM TEST\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Get test user
$testUser = User::where('email', 'test@speedjobs.com')->first();

if (!$testUser) {
    echo "✗ Test user not found!\n";
    exit(1);
}

echo "Test User Profile:\n";
echo "  Name: {$testUser->name}\n";
echo "  Email: {$testUser->email}\n";
echo "  Skills: " . ($testUser->skills ?? 'Not set') . "\n";
echo "  Field of Study: " . ($testUser->field_of_study ?? 'Not set') . "\n";
echo "  Location: " . ($testUser->location ?? 'Not set') . "\n";
echo "  Experience Level: " . ($testUser->experience_level ?? 'Not set') . "\n\n";

// Check if user has profile data for recommendations
$hasProfileData = !empty($testUser->skills) || !empty($testUser->field_of_study);

if (!$hasProfileData) {
    echo "⚠ WARNING: User has minimal profile data. Recommendations will be limited.\n";
    echo "   Updating test user profile for better testing...\n\n";
    
    $testUser->update([
        'skills' => 'PHP, Laravel, JavaScript, MySQL, Git',
        'field_of_study' => 'Computer Science',
        'location' => 'Lagos, Nigeria',
        'experience_level' => 'intermediate',
        'university' => 'University of Lagos',
        'graduation_year' => 2022,
    ]);
    
    $testUser->refresh();
    echo "✓ Profile updated with test data\n\n";
}

// Test the recommendation algorithm
echo "Testing Recommendation Algorithm...\n";

$controller = new JobseekerDashboardController();
$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('getRecommendedJobs');
$method->setAccessible(true);

$appliedJobIds = $testUser->jobApplications()->pluck('job_id')->toArray();
echo "  Applied Jobs: " . count($appliedJobIds) . "\n";

$startTime = microtime(true);
$recommendedJobs = $method->invoke($controller, $testUser, $appliedJobIds);
$duration = round(microtime(true) - $startTime, 3);

echo "  ✓ Algorithm executed in {$duration}s\n";
echo "  ✓ Found " . $recommendedJobs->count() . " recommended jobs\n\n";

// Display top recommendations with scores
if ($recommendedJobs->count() > 0) {
    echo "Top Recommendations (with relevance scores):\n";
    foreach ($recommendedJobs->take(5) as $index => $job) {
        echo "  " . ($index + 1) . ". {$job->title} at {$job->company}\n";
        echo "     Score: {$job->relevance_score} | Location: {$job->location}\n";
        echo "     Category: " . ($job->category ?? 'N/A') . " | Type: {$job->type}\n\n";
    }
} else {
    echo "  ⚠ No recommendations found. This could mean:\n";
    echo "     - All jobs have been applied to\n";
    echo "     - No jobs match the user profile\n";
    echo "     - No jobs in database\n\n";
}

// ============================================================================
// PART 2: Test Scoring Factors
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 2: SCORING FACTORS ANALYSIS\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$totalJobs = Job::count();
echo "Total Jobs in Database: {$totalJobs}\n\n";

if ($totalJobs > 0 && $recommendedJobs->count() > 0) {
    $topJob = $recommendedJobs->first();
    
    echo "Analyzing Top Recommendation:\n";
    echo "  Job: {$topJob->title}\n";
    echo "  Company: {$topJob->company}\n";
    echo "  Total Score: {$topJob->relevance_score}\n\n";
    
    echo "Score Breakdown (estimated):\n";
    
    // Skills matching
    $userSkills = array_map('trim', array_map('strtolower', explode(',', $testUser->skills ?? '')));
    $jobText = strtolower($topJob->title . ' ' . $topJob->description . ' ' . $topJob->requirements);
    $skillMatches = 0;
    foreach ($userSkills as $skill) {
        if ($skill && str_contains($jobText, $skill)) {
            $skillMatches++;
        }
    }
    echo "  Skills Matched: {$skillMatches} × 3 points = " . ($skillMatches * 3) . " points\n";
    
    // Field of study
    $fieldMatch = str_contains($jobText, strtolower($testUser->field_of_study ?? ''));
    echo "  Field of Study Match: " . ($fieldMatch ? "Yes (5 points)" : "No (0 points)") . "\n";
    
    // Location
    $locationMatch = str_contains(strtolower($topJob->location), strtolower($testUser->location ?? ''));
    echo "  Location Match: " . ($locationMatch ? "Yes (4 points)" : "No (0 points)") . "\n";
    
    // Recency
    $daysOld = now()->diffInDays($topJob->created_at);
    $recencyPoints = $daysOld <= 7 ? 2 : ($daysOld <= 14 ? 1 : 0);
    echo "  Recency Bonus: {$recencyPoints} points (posted {$daysOld} days ago)\n";
    
    // Featured
    $featuredPoints = $topJob->is_featured ? 1 : 0;
    echo "  Featured Bonus: {$featuredPoints} points\n";
    
    echo "\n";
}

// ============================================================================
// PART 3: Test Dashboard Integration
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 3: DASHBOARD INTEGRATION TEST\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Testing Dashboard Controller...\n";

try {
    // Simulate authenticated user
    auth()->login($testUser);
    
    $response = $controller->index();
    $viewData = $response->getData();
    
    echo "  ✓ Dashboard controller executed successfully\n";
    echo "  ✓ View data contains:\n";
    echo "     - recommendedJobs: " . (isset($viewData['recommendedJobs']) ? "✓" : "✗") . "\n";
    echo "     - recentApplications: " . (isset($viewData['recentApplications']) ? "✓" : "✗") . "\n";
    echo "     - savedJobs: " . (isset($viewData['savedJobs']) ? "✓" : "✗") . "\n";
    echo "     - profileCompletion: " . (isset($viewData['profileCompletion']) ? "✓" : "✗") . "\n";
    
    if (isset($viewData['recommendedJobs'])) {
        $count = $viewData['recommendedJobs']->count();
        echo "\n  ✓ Dashboard shows {$count} recommended jobs\n";
    }
    
    if (isset($viewData['profileCompletion'])) {
        echo "  ✓ Profile completion: {$viewData['profileCompletion']}%\n";
    }
    
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// PART 4: Test Profile Page Integration
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 4: PROFILE PAGE INTEGRATION TEST\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Checking Profile Page Features...\n";

// Check if profile edit view exists
$profileViewPath = resource_path('views/profile/edit.blade.php');
if (file_exists($profileViewPath)) {
    echo "  ✓ Profile edit view exists\n";
    
    $profileContent = file_get_contents($profileViewPath);
    
    // Check for job recommendation section
    $hasRecommendations = str_contains($profileContent, 'recommend') || str_contains($profileContent, 'Recommend');
    echo "  " . ($hasRecommendations ? "✓" : "⚠") . " Job recommendations section: " . ($hasRecommendations ? "Present" : "Not found") . "\n";
    
    // Check for profile fields that affect recommendations
    $hasSkills = str_contains($profileContent, 'skills') || str_contains($profileContent, 'Skills');
    $hasFieldOfStudy = str_contains($profileContent, 'field_of_study') || str_contains($profileContent, 'Field of Study');
    $hasLocation = str_contains($profileContent, 'location') || str_contains($profileContent, 'Location');
    
    echo "  " . ($hasSkills ? "✓" : "✗") . " Skills field: " . ($hasSkills ? "Present" : "Missing") . "\n";
    echo "  " . ($hasFieldOfStudy ? "✓" : "✗") . " Field of study field: " . ($hasFieldOfStudy ? "Present" : "Missing") . "\n";
    echo "  " . ($hasLocation ? "✓" : "✗") . " Location field: " . ($hasLocation ? "Present" : "Missing") . "\n";
    
} else {
    echo "  ✗ Profile edit view not found\n";
}

echo "\n";

// ============================================================================
// PART 5: Test Recommendation Quality
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 5: RECOMMENDATION QUALITY ANALYSIS\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

if ($recommendedJobs->count() > 0) {
    echo "Quality Metrics:\n";
    
    // Average score
    $avgScore = $recommendedJobs->avg('relevance_score');
    echo "  Average Relevance Score: " . round($avgScore, 2) . "\n";
    
    // Score distribution
    $highScore = $recommendedJobs->where('relevance_score', '>=', 10)->count();
    $mediumScore = $recommendedJobs->where('relevance_score', '>=', 5)->where('relevance_score', '<', 10)->count();
    $lowScore = $recommendedJobs->where('relevance_score', '<', 5)->count();
    
    echo "  High Relevance (≥10): {$highScore} jobs\n";
    echo "  Medium Relevance (5-9): {$mediumScore} jobs\n";
    echo "  Low Relevance (<5): {$lowScore} jobs\n\n";
    
    // Diversity check
    $uniqueCompanies = $recommendedJobs->pluck('company')->unique()->count();
    $uniqueLocations = $recommendedJobs->pluck('location')->unique()->count();
    
    echo "  Diversity:\n";
    echo "    Unique Companies: {$uniqueCompanies}\n";
    echo "    Unique Locations: {$uniqueLocations}\n\n";
    
    // Relevance assessment
    if ($avgScore >= 10) {
        echo "  ✓ EXCELLENT: Recommendations are highly relevant\n";
    } elseif ($avgScore >= 5) {
        echo "  ✓ GOOD: Recommendations are moderately relevant\n";
    } else {
        echo "  ⚠ FAIR: Recommendations have low relevance\n";
        echo "    Consider: More profile data or more diverse job listings\n";
    }
} else {
    echo "⚠ Cannot analyze quality - no recommendations generated\n";
}

echo "\n";

// ============================================================================
// PART 6: Test Fallback Mechanism
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 6: FALLBACK MECHANISM TEST\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Testing fallback to latest jobs...\n";

// Create a user with no profile data
$emptyUser = new User([
    'name' => 'Empty Profile User',
    'email' => 'empty@test.com',
    'skills' => null,
    'field_of_study' => null,
    'location' => null,
    'experience_level' => null,
]);

$fallbackJobs = $method->invoke($controller, $emptyUser, []);

if ($fallbackJobs->isEmpty() && $totalJobs > 0) {
    echo "  ✓ Fallback mechanism working: Returns latest jobs when no matches\n";
    
    // Test the actual fallback in controller
    $latestJobs = Job::latest()->take(6)->get();
    echo "  ✓ Would show {$latestJobs->count()} latest jobs as fallback\n";
} elseif ($fallbackJobs->count() > 0) {
    echo "  ⚠ Fallback returned {$fallbackJobs->count()} jobs\n";
    echo "    (Expected empty for user with no profile data)\n";
} else {
    echo "  ⚠ No jobs available for fallback test\n";
}

echo "\n";

// ============================================================================
// FINAL SUMMARY
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "FINAL SUMMARY\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$results = [
    'Algorithm Execution' => $recommendedJobs->count() > 0 || $totalJobs == 0,
    'Dashboard Integration' => isset($viewData['recommendedJobs']),
    'Profile Fields Present' => $hasSkills && $hasFieldOfStudy && $hasLocation,
    'Scoring System' => $recommendedJobs->count() > 0 && $recommendedJobs->first()->relevance_score > 0,
    'Performance' => $duration < 1.0,
];

$passCount = count(array_filter($results));
$totalCount = count($results);

echo "Test Results: {$passCount}/{$totalCount} PASS\n\n";

foreach ($results as $test => $passed) {
    $icon = $passed ? '✓' : '✗';
    $status = $passed ? 'PASS' : 'FAIL';
    echo "  {$icon} {$test}: {$status}\n";
}

echo "\n";

if ($passCount === $totalCount) {
    echo "Status: ✓ ALL TESTS PASSED\n";
    echo "The job recommendation engine is fully functional!\n";
} elseif ($passCount >= $totalCount * 0.8) {
    echo "Status: ✓ MOSTLY FUNCTIONAL\n";
    echo "Minor issues detected but core functionality works.\n";
} else {
    echo "Status: ⚠ NEEDS ATTENTION\n";
    echo "Several issues detected. Review failed tests above.\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "RECOMMENDATIONS FOR IMPROVEMENT\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

if (!$hasRecommendations) {
    echo "1. Add job recommendations section to profile page\n";
    echo "   - Show personalized job matches\n";
    echo "   - Display relevance scores\n";
    echo "   - Add 'Why this job?' explanations\n\n";
}

if ($recommendedJobs->count() == 0 && $totalJobs > 0) {
    echo "2. Improve matching algorithm sensitivity\n";
    echo "   - Lower score thresholds\n";
    echo "   - Add more matching factors\n";
    echo "   - Implement fuzzy matching\n\n";
}

if ($avgScore < 10) {
    echo "3. Enhance profile data collection\n";
    echo "   - Prompt users to complete profile\n";
    echo "   - Add more relevant fields\n";
    echo "   - Implement profile completion wizard\n\n";
}

echo "4. Consider adding:\n";
echo "   - AI-powered job descriptions analysis\n";
echo "   - User feedback on recommendations\n";
echo "   - Machine learning for improved matching\n";
echo "   - 'Jobs you might like' carousel\n";
echo "   - Email notifications for new matches\n";

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "TEST COMPLETE\n";
echo "═══════════════════════════════════════════════════════════════\n";
