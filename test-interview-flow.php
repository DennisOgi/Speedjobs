<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AiSession;
use App\Models\AiSessionStep;

echo "=== INTERVIEW PREP FLOW DIAGNOSTIC ===\n\n";

// Find a test user
$user = User::where('is_paid', true)->first();
if (!$user) {
    echo "❌ No paid user found. Creating one...\n";
    $user = User::factory()->create(['is_paid' => true]);
}

echo "✓ Using user: {$user->name} (ID: {$user->id})\n\n";

// Find or create an interview prep session
$session = AiSession::where('user_id', $user->id)
    ->where('module', 'interview_prep')
    ->where('status', 'in_progress')
    ->latest()
    ->first();

if (!$session) {
    echo "Creating new interview prep session...\n";
    $session = AiSession::create([
        'user_id' => $user->id,
        'module' => 'interview_prep',
        'status' => 'in_progress',
        'current_step' => 0,
        'total_steps' => 11,
        'context_data' => [
            'user_name' => $user->name,
            'target_role' => 'Software Engineer',
        ],
    ]);
    echo "✓ Created session ID: {$session->id}\n\n";
} else {
    echo "✓ Found existing session ID: {$session->id}\n\n";
}

echo "SESSION STATE:\n";
echo "- Module: {$session->module}\n";
echo "- Status: {$session->status}\n";
echo "- Current Step: {$session->current_step}\n";
echo "- Total Steps: {$session->total_steps}\n";
echo "- Steps Count: " . $session->steps()->count() . "\n\n";

// Show all steps
$steps = $session->steps()->orderBy('step_number')->get();
echo "STEPS DETAIL:\n";
foreach ($steps as $step) {
    echo "Step #{$step->step_number}:\n";
    echo "  Type: {$step->step_type}\n";
    echo "  Question: " . substr($step->prompt, 0, 60) . "...\n";
    echo "  Has Answer: " . ($step->response ? 'YES' : 'NO') . "\n";
    if ($step->response) {
        echo "  Answer: " . substr($step->response, 0, 60) . "...\n";
    }
    if (isset($step->metadata['evaluation'])) {
        echo "  Score: " . ($step->metadata['evaluation']['score'] ?? 'N/A') . "\n";
    }
    echo "\n";
}

// Test getStepData logic
echo "=== TESTING getStepData LOGIC ===\n\n";

echo "OLD Query: \$session->steps()->orderByDesc('step_number')->first()\n";
$allStepsDesc = $session->steps()->orderByDesc('step_number')->get();
echo "All steps in DESC order:\n";
foreach ($allStepsDesc as $s) {
    echo "  - Step #{$s->step_number}, Has Response: " . ($s->response ? 'YES' : 'NO') . "\n";
}
echo "\n";

$oldLatestStep = $session->steps()->orderByDesc('step_number')->first();
echo "OLD Latest Step: #{$oldLatestStep->step_number}\n";
echo "OLD Has Response: " . ($oldLatestStep->response ? 'YES' : 'NO') . "\n\n";

echo "NEW Method: \$session->latestStep()\n";
$latestStep = $session->latestStep();

if ($latestStep) {
    echo "Latest Step: #{$latestStep->step_number}\n";
    echo "Has Response: " . ($latestStep->response ? 'YES' : 'NO') . "\n";
    echo "Response Empty Check: " . (empty($latestStep->response) ? 'TRUE (empty)' : 'FALSE (has content)') . "\n\n";
    
    if (empty($latestStep->response)) {
        echo "✓ SHOULD SHOW: interview_answer form\n";
        echo "  Question: {$latestStep->prompt}\n";
    } else {
        echo "✓ SHOULD SHOW: loading state (generating next question)\n";
    }
} else {
    echo "❌ No steps found - this is the problem!\n";
    echo "Session current_step is {$session->current_step} but no steps exist.\n";
}

echo "\n=== DIAGNOSIS COMPLETE ===\n";

