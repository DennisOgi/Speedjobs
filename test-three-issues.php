<?php

/**
 * Test Three Issues:
 * 1. Career Intelligence Report AI generation
 * 2. All Courses button navigation
 * 3. Resume builder font sizes
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Route;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║              THREE ISSUES DIAGNOSTIC TEST                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$testsPassed = 0;
$testsFailed = 0;

// ISSUE 1: Career Intelligence Report
echo "ISSUE 1: Career Intelligence Report Feature\n";
echo str_repeat("-", 70) . "\n";

try {
    // Check if route exists
    $routeExists = Route::has('ai-counselor.profile-report');
    if ($routeExists) {
        echo "✓ PASS: Route 'ai-counselor.profile-report' exists\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: Route 'ai-counselor.profile-report' not found\n";
        $testsFailed++;
    }
    
    // Check if controller method exists
    $controllerPath = __DIR__ . '/app/Http/Controllers/AiCounselorController.php';
    $controllerContent = file_get_contents($controllerPath);
    
    if (strpos($controllerContent, 'function profileReport') !== false) {
        echo "✓ PASS: AiCounselorController has profileReport method\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: profileReport method not found in controller\n";
        $testsFailed++;
    }
    
    // Check if GeminiService has generateProfileReport method
    $geminiPath = __DIR__ . '/app/Services/GeminiService.php';
    $geminiContent = file_get_contents($geminiPath);
    
    if (strpos($geminiContent, 'function generateProfileReport') !== false) {
        echo "✓ PASS: GeminiService has generateProfileReport method\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: generateProfileReport method not found in GeminiService\n";
        $testsFailed++;
    }
    
    // Test AI generation with test user
    $user = User::where('email', 'test@speedjobs.com')->first();
    if ($user && $user->is_paid) {
        echo "✓ PASS: Test user is premium (can access feature)\n";
        $testsPassed++;
        
        // Try to generate a report
        try {
            $gemini = new GeminiService();
            $context = [
                'name' => $user->name,
                'email' => $user->email,
                'skills' => $user->skills,
                'field_of_study' => $user->field_of_study,
                'experience_level' => $user->experience_level,
                'location' => $user->location,
            ];
            
            echo "  Testing AI generation (this may take a few seconds)...\n";
            $startTime = microtime(true);
            $report = $gemini->generateProfileReport($context);
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($report && is_array($report)) {
                echo "✓ PASS: AI generated profile report successfully ({$duration}ms)\n";
                echo "  - Report has summary: " . (isset($report['summary']) ? 'Yes' : 'No') . "\n";
                echo "  - Report has strengths: " . (isset($report['strengths']) ? 'Yes' : 'No') . "\n";
                echo "  - Report has improvement areas: " . (isset($report['improvement_areas']) ? 'Yes' : 'No') . "\n";
                echo "  - Report has recommended roles: " . (isset($report['recommended_roles']) ? 'Yes' : 'No') . "\n";
                echo "  - Report has action plan: " . (isset($report['action_plan']) ? 'Yes' : 'No') . "\n";
                $testsPassed++;
            } else {
                echo "✗ FAIL: AI did not generate valid report\n";
                $testsFailed++;
            }
        } catch (Exception $e) {
            echo "✗ FAIL: AI generation error: " . $e->getMessage() . "\n";
            $testsFailed++;
        }
    } else {
        echo "⚠ WARNING: Test user not premium or not found\n";
    }
    
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed++;
}
echo "\n";

// ISSUE 2: All Courses Button
echo "ISSUE 2: All Courses Button Navigation\n";
echo str_repeat("-", 70) . "\n";

try {
    // Check if courses.index route exists
    $routeExists = Route::has('courses.index');
    if ($routeExists) {
        echo "✓ PASS: Route 'courses.index' exists\n";
        $testsPassed++;
        
        // Get the route URL
        $url = route('courses.index');
        echo "  - Route URL: {$url}\n";
    } else {
        echo "✗ FAIL: Route 'courses.index' not found\n";
        $testsFailed++;
    }
    
    // Check if CourseController exists and has index method
    $controllerPath = __DIR__ . '/app/Http/Controllers/CourseController.php';
    if (file_exists($controllerPath)) {
        echo "✓ PASS: CourseController exists\n";
        $testsPassed++;
        
        $controllerContent = file_get_contents($controllerPath);
        if (strpos($controllerContent, 'function index') !== false) {
            echo "✓ PASS: CourseController has index method\n";
            $testsPassed++;
        } else {
            echo "✗ FAIL: index method not found in CourseController\n";
            $testsFailed++;
        }
    } else {
        echo "✗ FAIL: CourseController not found\n";
        $testsFailed += 2;
    }
    
    // Check if courses.index view exists
    $viewPath = __DIR__ . '/resources/views/courses/index.blade.php';
    if (file_exists($viewPath)) {
        echo "✓ PASS: courses/index.blade.php view exists\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: courses/index.blade.php view not found\n";
        $testsFailed++;
    }
    
    // Check if "All Courses" button exists in dashboard
    $dashboardPath = __DIR__ . '/resources/views/dashboard.blade.php';
    $dashboardContent = file_get_contents($dashboardPath);
    
    if (strpos($dashboardContent, 'View All Courses') !== false || strpos($dashboardContent, 'All Courses') !== false) {
        echo "✓ PASS: 'All Courses' button found in dashboard\n";
        $testsPassed++;
    } else {
        echo "✗ FAIL: 'All Courses' button not found in dashboard\n";
        $testsFailed++;
    }
    
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed++;
}
echo "\n";

// ISSUE 3: Resume Builder Font Sizes
echo "ISSUE 3: Resume Builder Font Sizes\n";
echo str_repeat("-", 70) . "\n";

try {
    // Check resume templates
    $templatesDir = __DIR__ . '/resources/views/resume/templates';
    $templates = glob($templatesDir . '/*.blade.php');
    
    echo "  Found " . count($templates) . " resume templates\n";
    
    $fontIssues = [];
    foreach ($templates as $templatePath) {
        $templateName = basename($templatePath, '.blade.php');
        $content = file_get_contents($templatePath);
        
        // Check for large font sizes
        if (preg_match('/text-(4xl|5xl|6xl|7xl|8xl|9xl)/', $content, $matches)) {
            $fontIssues[] = "$templateName: Found large heading ({$matches[0]})";
        }
        
        // Check for text-xl or text-2xl in job titles/professional titles
        if (preg_match('/text-(xl|2xl).*?(job_title|Professional Title)/', $content, $matches)) {
            $fontIssues[] = "$templateName: Job title may be too large ({$matches[1]})";
        }
    }
    
    if (count($fontIssues) > 0) {
        echo "⚠ POTENTIAL ISSUES FOUND:\n";
        foreach ($fontIssues as $issue) {
            echo "  - $issue\n";
        }
        echo "\n";
        echo "  ANALYSIS:\n";
        echo "  - Name heading (text-4xl): May be too large for professional resume\n";
        echo "  - Job title (text-xl/2xl): May be too large, should be text-lg or smaller\n";
        echo "  - Body text: Should be text-sm or text-base for readability\n";
        echo "  - Section headings: Should be text-xs or text-sm uppercase\n";
        echo "\n";
        echo "  RECOMMENDATION: Reduce font sizes for more professional look\n";
        echo "  - Name: text-3xl or text-2xl (currently text-4xl)\n";
        echo "  - Job Title: text-base or text-lg (currently text-xl/2xl)\n";
        echo "  - Body: text-sm (good)\n";
        echo "  - Headings: text-xs uppercase (good)\n";
    } else {
        echo "✓ PASS: No obvious font size issues found\n";
        $testsPassed++;
    }
    
    // Check specific templates mentioned in screenshot
    $professionalPath = $templatesDir . '/professional.blade.php';
    if (file_exists($professionalPath)) {
        $content = file_get_contents($professionalPath);
        echo "\n  PROFESSIONAL TEMPLATE ANALYSIS:\n";
        
        // Check name size
        if (preg_match('/text-4xl.*?full_name/', $content)) {
            echo "  ⚠ Name: text-4xl (TOO LARGE - recommend text-2xl or text-3xl)\n";
        }
        
        // Check job title size
        if (preg_match('/text-xl.*?job_title/', $content)) {
            echo "  ⚠ Job Title: text-xl (TOO LARGE - recommend text-base or text-lg)\n";
        }
        
        // Check body text
        if (preg_match('/text-sm/', $content)) {
            echo "  ✓ Body text: text-sm (GOOD)\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ FAIL: " . $e->getMessage() . "\n";
    $testsFailed++;
}
echo "\n";

// Summary
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                        TEST SUMMARY                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "Tests Passed: {$testsPassed}\n";
echo "Tests Failed: {$testsFailed}\n";
echo "\n";

echo "ISSUE STATUS:\n";
echo "1. Career Intelligence Report: " . ($testsPassed >= 5 ? "✓ WORKING" : "⚠ NEEDS ATTENTION") . "\n";
echo "2. All Courses Button: " . (Route::has('courses.index') ? "✓ WORKING" : "✗ NOT WORKING") . "\n";
echo "3. Resume Font Sizes: ⚠ NEEDS ADJUSTMENT (see analysis above)\n";
echo "\n";
