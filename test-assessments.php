<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AssessmentResult;
use App\Services\GeminiService;

echo "=== ASSESSMENT SYSTEM TEST ===\n\n";

// Test 1: Check if Gemini service is available
echo "1. Testing Gemini Service...\n";
try {
    $gemini = app(GeminiService::class);
    echo "   ✓ Gemini service initialized\n";
    echo "   API Key: " . (config('services.gemini.api_key') ? 'Configured' : 'Missing') . "\n\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Check assessment types
echo "2. Testing Assessment Types...\n";
$controller = new \App\Http\Controllers\AssessmentController($gemini);
$reflection = new ReflectionClass($controller);
$property = $reflection->getProperty('assessmentTypes');
$property->setAccessible(true);
$types = $property->getValue($controller);

foreach ($types as $type => $info) {
    echo "   ✓ {$info['title']} ({$type})\n";
    echo "     Duration: {$info['duration']}\n";
}
echo "\n";

// Test 3: Check questions for each type
echo "3. Testing Question Banks...\n";
$method = $reflection->getMethod('getQuestions');
$method->setAccessible(true);

foreach (array_keys($types) as $type) {
    $questions = $method->invoke($controller, $type);
    echo "   ✓ {$type}: " . count($questions) . " questions\n";
}
echo "\n";

// Test 4: Test AI Analysis (if user exists)
echo "4. Testing AI Analysis...\n";
$user = User::where('is_paid', true)->first();

if ($user) {
    echo "   Testing with user: {$user->name}\n";
    
    try {
        $questions = $method->invoke($controller, 'personality');
        $answers = array_fill(0, count($questions), 'Agree');
        
        $userProfile = [
            'name' => $user->name,
            'university' => $user->university,
            'field_of_study' => $user->field_of_study,
            'experience_level' => $user->experience_level,
        ];
        
        echo "   Sending request to Gemini AI...\n";
        $analysis = $gemini->analyzeAssessment('personality', array_slice($questions, 0, 5), array_slice($answers, 0, 5), $userProfile);
        
        if (!empty($analysis)) {
            echo "   ✓ AI Analysis received (" . strlen($analysis) . " characters)\n";
            echo "   Preview: " . substr($analysis, 0, 100) . "...\n";
        } else {
            echo "   ✗ No analysis received\n";
        }
    } catch (Exception $e) {
        echo "   ✗ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ⚠ No paid user found for testing\n";
}
echo "\n";

// Test 5: Check existing assessment results
echo "5. Checking Existing Assessment Results...\n";
$results = AssessmentResult::with('user')->latest()->take(5)->get();

if ($results->count() > 0) {
    echo "   Found {$results->count()} recent assessments:\n";
    foreach ($results as $result) {
        echo "   - {$result->assessment_type} by {$result->user->name} (Score: {$result->overall_score}%)\n";
    }
} else {
    echo "   No assessment results found yet\n";
}
echo "\n";

// Test 6: Check routes
echo "6. Checking Assessment Routes...\n";
$routes = [
    'assessments.index' => 'GET /assessments',
    'assessments.show' => 'GET /assessments/{type}',
    'assessments.submit' => 'POST /assessments/{type}/submit',
    'assessments.results' => 'GET /assessments/results/{result}',
    'assessments.download' => 'GET /assessments/results/{result}/download',
];

foreach ($routes as $name => $path) {
    try {
        $url = route($name, $name === 'assessments.show' || $name === 'assessments.submit' ? 'personality' : ($name === 'assessments.results' || $name === 'assessments.download' ? 1 : []));
        echo "   ✓ {$name}: {$path}\n";
    } catch (Exception $e) {
        echo "   ✗ {$name}: Route not found\n";
    }
}
echo "\n";

echo "=== TEST COMPLETE ===\n";
echo "\nTo test the assessments:\n";
echo "1. Visit: " . url('/assessments') . "\n";
echo "2. Choose an assessment type\n";
echo "3. Complete the questions\n";
echo "4. View your AI-powered results\n";
