<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AiSession;
use App\Services\GeminiService;

echo "=== TESTING INTERVIEW PREP FLOW ===\n\n";

// Get test user
$user = User::where('email', 'test@speedjobs.com')->first();
if (!$user) {
    echo "❌ Test user not found\n";
    exit(1);
}

echo "✓ Test user found: {$user->email}\n\n";

// Test 1: Check if GeminiService methods exist
echo "TEST 1: GeminiService Methods\n";
echo "-----------------------------------\n";
$gemini = new GeminiService();

if (method_exists($gemini, 'generateInterviewQuestion')) {
    echo "✓ generateInterviewQuestion() exists\n";
} else {
    echo "❌ generateInterviewQuestion() missing\n";
}

if (method_exists($gemini, 'evaluateInterviewAnswer')) {
    echo "✓ evaluateInterviewAnswer() exists\n";
} else {
    echo "❌ evaluateInterviewAnswer() missing\n";
}

if (method_exists($gemini, 'generateInterviewReport')) {
    echo "✓ generateInterviewReport() exists\n";
} else {
    echo "❌ generateInterviewReport() missing\n";
}

// Test 2: Try generating a question
echo "\nTEST 2: Generate Interview Question\n";
echo "-----------------------------------\n";
try {
    $question = $gemini->generateInterviewQuestion('Software Engineer', 1);
    echo "✓ Question generated successfully\n";
    echo "Question: " . ($question['question'] ?? 'N/A') . "\n";
    echo "Type: " . ($question['question_type'] ?? 'N/A') . "\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Test 3: Check existing interview prep sessions
echo "\nTEST 3: Existing Interview Prep Sessions\n";
echo "-----------------------------------\n";
$sessions = AiSession::where('user_id', $user->id)
    ->where('module', 'interview_prep')
    ->orderByDesc('created_at')
    ->take(3)
    ->get();

if ($sessions->isEmpty()) {
    echo "No interview prep sessions found\n";
} else {
    foreach ($sessions as $session) {
        echo "\nSession ID: {$session->id}\n";
        echo "Status: {$session->status}\n";
        echo "Current Step: {$session->current_step}/{$session->total_steps}\n";
        echo "Target Role: " . ($session->context_data['target_role'] ?? 'N/A') . "\n";
        echo "Steps Count: " . $session->steps->count() . "\n";
        
        if ($session->steps->isNotEmpty()) {
            echo "Latest Step:\n";
            $latest = $session->steps->last();
            echo "  - Step Number: {$latest->step_number}\n";
            echo "  - Type: {$latest->step_type}\n";
            echo "  - Has Response: " . (empty($latest->response) ? 'NO' : 'YES') . "\n";
            echo "  - Prompt: " . substr($latest->prompt, 0, 100) . "...\n";
        }
    }
}

// Test 4: Simulate the flow
echo "\n\nTEST 4: Simulate Interview Prep Flow\n";
echo "-----------------------------------\n";

// Create a test session
$testSession = AiSession::create([
    'user_id' => $user->id,
    'module' => 'interview_prep',
    'status' => 'in_progress',
    'current_step' => 0,
    'total_steps' => 6,
    'context_data' => ['target_role' => 'Product Manager'],
]);

echo "✓ Created test session ID: {$testSession->id}\n";

// Simulate step 0 -> should generate first question
echo "\nStep 0: Initial state (should generate first question)\n";
echo "Current step: {$testSession->current_step}\n";
echo "Steps count: {$testSession->steps->count()}\n";
echo "Steps isEmpty: " . ($testSession->steps->isEmpty() ? 'YES' : 'NO') . "\n";

if ($testSession->current_step === 0 && $testSession->steps->isEmpty()) {
    echo "✓ Condition met: Should generate first question\n";
    
    try {
        $questionData = $gemini->generateInterviewQuestion('Product Manager', 1);
        echo "✓ First question generated\n";
        echo "Question: " . ($questionData['question'] ?? 'N/A') . "\n";
    } catch (\Exception $e) {
        echo "❌ Error generating question: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Condition NOT met\n";
}

// Clean up test session
$testSession->delete();
echo "\n✓ Test session cleaned up\n";

echo "\n=== DIAGNOSIS COMPLETE ===\n";
