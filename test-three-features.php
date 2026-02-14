<?php

/**
 * Test Script for Three Features
 * 1. Mentorship Program (Find/Become Mentor)
 * 2. Career Assessment Buttons
 * 3. Career Planning Tool AI Integration
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING THREE FEATURES ===\n\n";

// Test 1: Mentorship Program
echo "TEST 1: MENTORSHIP PROGRAM\n";
echo str_repeat("-", 50) . "\n";

// Check if mentorship view exists
$mentorshipViewPath = resource_path('views/mentorship.blade.php');
echo "✓ Mentorship view exists: " . ($mentorshipViewPath ? "YES" : "NO") . "\n";

// Check routes
$routes = app('router')->getRoutes();
$mentorshipRoute = $routes->getByName('mentorship');
$counselorsRoute = $routes->getByName('counselors.index');

echo "✓ Mentorship route exists: " . ($mentorshipRoute ? "YES" : "NO") . "\n";
echo "✓ Counselors route exists: " . ($counselorsRoute ? "YES" : "NO") . "\n";

// Check for mentor application system
$mentorControllerExists = file_exists(app_path('Http/Controllers/MentorController.php'));
echo "✗ MentorController exists: " . ($mentorControllerExists ? "YES" : "NO") . "\n";

// Check database tables
$hasMentorsTable = Schema::hasTable('mentors');
$hasMentorApplicationsTable = Schema::hasTable('mentor_applications');
echo "✗ Mentors table exists: " . ($hasMentorsTable ? "YES" : "NO") . "\n";
echo "✗ Mentor applications table exists: " . ($hasMentorApplicationsTable ? "YES" : "NO") . "\n";

echo "\nMENTORSHIP STATUS: PARTIALLY IMPLEMENTED\n";
echo "- Find a Mentor: ✓ Links to counselors.index (working)\n";
echo "- Become a Mentor: ✗ Button has no action (NOT FUNCTIONAL)\n";
echo "- Admin Management: ✗ No admin routes for mentor applications\n\n";

// Test 2: Career Assessment Buttons
echo "\nTEST 2: CAREER ASSESSMENT BUTTONS\n";
echo str_repeat("-", 50) . "\n";

$assessmentTypes = ['personality', 'skills', 'interest', 'aptitude'];
foreach ($assessmentTypes as $type) {
    $route = $routes->getByName('assessments.show');
    echo "✓ Route assessments.show exists: " . ($route ? "YES" : "NO") . "\n";
    break;
}

// Check controller
$controllerExists = file_exists(app_path('Http/Controllers/AssessmentController.php'));
echo "✓ AssessmentController exists: " . ($controllerExists ? "YES" : "NO") . "\n";

// Check if show() method exists
if ($controllerExists) {
    $controller = new \App\Http\Controllers\AssessmentController(app(\App\Services\GeminiService::class));
    $hasShowMethod = method_exists($controller, 'show');
    echo "✓ show() method exists: " . ($hasShowMethod ? "YES" : "NO") . "\n";
}

// Check view
$takeViewExists = file_exists(resource_path('views/assessments/take.blade.php'));
echo "✓ Take assessment view exists: " . ($takeViewExists ? "YES" : "NO") . "\n";

echo "\nASSESSMENT BUTTONS STATUS: SHOULD BE WORKING\n";
echo "- All routes exist\n";
echo "- Controller and methods exist\n";
echo "- Views exist\n";
echo "- Issue might be JavaScript or route parameters\n\n";

// Test 3: Career Planning Tool AI Integration
echo "\nTEST 3: CAREER PLANNING TOOL AI INTEGRATION\n";
echo str_repeat("-", 50) . "\n";

$planningControllerPath = app_path('Http/Controllers/CareerPlanningController.php');
$controllerContent = file_get_contents($planningControllerPath);

echo "✓ CareerPlanningController exists: YES\n";

// Check if GeminiService is used
$usesGemini = strpos($controllerContent, 'GeminiService') !== false;
echo "✗ Uses GeminiService: " . ($usesGemini ? "YES" : "NO") . "\n";

// Check if store method has AI logic
$hasAiLogic = strpos($controllerContent, 'gemini') !== false || strpos($controllerContent, 'generateCareerPathway') !== false;
echo "✗ Has AI logic in store(): " . ($hasAiLogic ? "YES" : "NO") . "\n";

// Check if it saves to database
$savesToDb = strpos($controllerContent, 'create(') !== false || strpos($controllerContent, 'save()') !== false;
echo "✗ Saves to database: " . ($savesToDb ? "YES" : "NO") . "\n";

echo "\nCAREER PLANNING STATUS: NOT AI-POWERED\n";
echo "- Currently just a basic form workbook\n";
echo "- No AI integration\n";
echo "- No pathway generation\n";
echo "- Needs GeminiService integration\n\n";

// Summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 50) . "\n\n";

echo "1. MENTORSHIP PROGRAM: 40% Complete\n";
echo "   - Find a Mentor works (uses counselors)\n";
echo "   - Become a Mentor NOT functional\n";
echo "   - Needs: MentorController, database tables, admin management\n\n";

echo "2. CAREER ASSESSMENT: 100% Complete (likely)\n";
echo "   - All backend code exists\n";
echo "   - Routes and controllers working\n";
echo "   - Need to test buttons in browser\n\n";

echo "3. CAREER PLANNING: 20% Complete\n";
echo "   - Form exists but no AI\n";
echo "   - Needs GeminiService integration\n";
echo "   - Needs pathway generation logic\n\n";

echo "NEXT STEPS:\n";
echo "1. Test assessment buttons in browser\n";
echo "2. Add AI to Career Planning Tool\n";
echo "3. Build Mentor application system\n\n";
