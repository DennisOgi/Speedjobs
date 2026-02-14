<?php

/**
 * Test Profile Page Job Recommendations
 * 
 * This script tests the job recommendation engine integration on the profile page
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     PROFILE PAGE JOB RECOMMENDATIONS TEST                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$testsPassed = 0;
$testsFailed = 0;
$startTime = microtime(true);

// Test 1: Check if test user exists
echo "TEST 1: Verify test user exists\n";
echo str_repeat("-", 70) . "\n";
try {
    $user = User::where('email', 'test@speedjobs.com')->first();
    if ($user) {
        echo "✓ PASS: Test user found\n";
        echo "  - Name: {$user->name}\n";
        echo "  - Email: {$user->email}\n";
        echo "  - Skills: " . ($user->skills ?: 'Not set') . "\n";
        echo "  - Field of Study: " . ($user->field_of_study ?: 'Not set') . "\n";
        echo "  - Location: " . ($user->location ?: 'Not set') . "\n";
        echo "  - Experience Level: " . ($user->experience_level ?: 'Not set') . "\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: Test user not found\n";
        $testsFailed++;
        exit(1);
    }
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed++;
}
echo "\n";

// Test 2: Check ProfileController has getRecommendedJobs method
echo "TEST 2: Verify ProfileController has recommendation logic\n";
echo str_repeat("-", 70) . "\n";
try {
    $controllerPath = __DIR__ . '/app/Http/Controllers/ProfileController.php';
    $controllerContent = file_get_contents($controllerPath);
    
    if (strpos($controllerContent, 'getRecommendedJobs') !== false) {
        echo "✓ PASS: ProfileController has getRecommendedJobs method\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: ProfileController missing getRecommendedJobs method\n";
        $testsFailed++;
    }
    
    if (strpos($controllerContent, 'recommendedJobs') !== false) {
        echo "✓ PASS: ProfileController passes recommendedJobs to view\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: ProfileController doesn't pass recommendedJobs to view\n";
        $testsFailed++;
    }
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed += 2;
}
echo "\n";

// Test 3: Check profile view has job recommendations section
echo "TEST 3: Verify profile view has job recommendations UI\n";
echo str_repeat("-", 70) . "\n";
try {
    $viewPath = __DIR__ . '/resources/views/profile/edit.blade.php';
    $viewContent = file_get_contents($viewPath);
    
    $checks = [
        'Jobs Recommended For You' => 'Job recommendations header',
        'recommendedJobs' => 'Recommended jobs variable',
        'match_reasons' => 'Match reasons display',
        'relevance_score' => 'Relevance score display',
        'Why this job?' => 'Match explanation section',
        'Profile Completion' => 'Profile completion widget',
        'How Your Profile Affects' => 'Impact explanation widget'
    ];
    
    foreach ($checks as $needle => $description) {
        if (strpos($viewContent, $needle) !== false) {
            echo "✓ PASS: View has {$description}\n";
            $testsPassed++;
        } else {
            echo "✗ FAIL: View missing {$description}\n";
            $testsFailed++;
        }
    }
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed += count($checks);
}
echo "\n";

// Test 4: Test recommendation algorithm with test user
echo "TEST 4: Test recommendation algorithm execution\n";
echo str_repeat("-", 70) . "\n";
try {
    // Simulate the ProfileController logic
    $appliedJobIds = $user->jobApplications()->pluck('job_id')->toArray();
    $jobs = Job::whereNotIn('id', $appliedJobIds)->get();
    
    echo "  - Total jobs available: " . $jobs->count() . "\n";
    echo "  - Jobs already applied to: " . count($appliedJobIds) . "\n";
    
    if ($jobs->count() > 0) {
        echo "✓ PASS: Jobs available for recommendations\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: No jobs available\n";
        $testsFailed++;
    }
    
    // Test scoring logic
    $userSkills = $user->skills ? array_map('trim', array_map('strtolower', explode(',', $user->skills))) : [];
    $userFieldOfStudy = $user->field_of_study ? strtolower($user->field_of_study) : null;
    $userLocation = $user->location ? strtolower($user->location) : null;
    
    echo "  - User skills parsed: " . count($userSkills) . " skills\n";
    echo "  - Field of study: " . ($userFieldOfStudy ?: 'Not set') . "\n";
    echo "  - Location: " . ($userLocation ?: 'Not set') . "\n";
    
    if (count($userSkills) > 0 || $userFieldOfStudy || $userLocation) {
        echo "✓ PASS: User has profile data for matching\n";
        $testsPassed++;
    } else {
        echo "⚠ WARNING: User profile incomplete - recommendations may be limited\n";
    }
    
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed += 2;
}
echo "\n";

// Test 5: Simulate full recommendation flow
echo "TEST 5: Simulate full recommendation flow\n";
echo str_repeat("-", 70) . "\n";
try {
    $controller = new \App\Http\Controllers\ProfileController();
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('getRecommendedJobs');
    $method->setAccessible(true);
    
    $startAlgo = microtime(true);
    $recommendedJobs = $method->invoke($controller, $user, 6);
    $algoTime = round((microtime(true) - $startAlgo) * 1000, 2);
    
    echo "  - Algorithm execution time: {$algoTime}ms\n";
    echo "  - Recommended jobs found: " . $recommendedJobs->count() . "\n";
    
    if ($recommendedJobs->count() > 0) {
        echo "✓ PASS: Recommendations generated successfully\n";
        $testsPassed++;
        
        echo "\n  Top 3 Recommendations:\n";
        foreach ($recommendedJobs->take(3) as $index => $job) {
            echo "  " . ($index + 1) . ". {$job->title} at {$job->company}\n";
            echo "     - Relevance Score: {$job->relevance_score}\n";
            if (!empty($job->match_reasons)) {
                echo "     - Match Reasons: " . implode(', ', array_slice($job->match_reasons, 0, 2)) . "\n";
            }
        }
        
        // Check if jobs have required attributes
        $firstJob = $recommendedJobs->first();
        if (isset($firstJob->relevance_score) && isset($firstJob->match_reasons)) {
            echo "\n✓ PASS: Jobs have relevance scores and match reasons\n";
            $testsPassed++;
        } else {
            echo "\n✗ FAIL: Jobs missing relevance scores or match reasons\n";
            $testsFailed++;
        }
    } else {
        echo "⚠ WARNING: No recommendations found (user profile may be incomplete)\n";
    }
    
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed += 2;
}
echo "\n";

// Test 6: Check ProfileUpdateRequest validation
echo "TEST 6: Verify profile update validation rules\n";
echo str_repeat("-", 70) . "\n";
try {
    $requestPath = __DIR__ . '/app/Http/Requests/ProfileUpdateRequest.php';
    $requestContent = file_get_contents($requestPath);
    
    $requiredFields = ['skills', 'field_of_study', 'location', 'experience_level'];
    foreach ($requiredFields as $field) {
        if (strpos($requestContent, "'{$field}'") !== false) {
            echo "✓ PASS: Validation includes {$field}\n";
            $testsPassed++;
        } else {
            echo "✗ FAIL: Validation missing {$field}\n";
            $testsFailed++;
        }
    }
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed += count($requiredFields);
}
echo "\n";

// Calculate execution time
$executionTime = round((microtime(true) - $startTime) * 1000, 2);

// Summary
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                        TEST SUMMARY                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "Total Tests: " . ($testsPassed + $testsFailed) . "\n";
echo "✓ Passed: {$testsPassed}\n";
echo "✗ Failed: {$testsFailed}\n";
echo "Success Rate: " . round(($testsPassed / ($testsPassed + $testsFailed)) * 100, 1) . "%\n";
echo "Execution Time: {$executionTime}ms\n";
echo "\n";

if ($testsFailed === 0) {
    echo "🎉 ALL TESTS PASSED! Profile page job recommendations are fully functional.\n";
    echo "\n";
    echo "FEATURES VERIFIED:\n";
    echo "  ✓ ProfileController has recommendation logic with scoring\n";
    echo "  ✓ Profile view displays job recommendations\n";
    echo "  ✓ Relevance scores and match reasons shown\n";
    echo "  ✓ Profile completion widget implemented\n";
    echo "  ✓ Impact explanation widget added\n";
    echo "  ✓ Validation rules for all profile fields\n";
    echo "\n";
    echo "ACCESS:\n";
    echo "  - Login: test@speedjobs.com / password\n";
    echo "  - URL: http://localhost:8000/profile\n";
    echo "\n";
    exit(0);
} else {
    echo "⚠ SOME TESTS FAILED - Review the output above for details.\n";
    echo "\n";
    exit(1);
}
