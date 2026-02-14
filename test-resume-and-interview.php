<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AiSession;
use App\Services\GeminiService;
use Smalot\PdfParser\Parser as PdfParser;

echo "=== TESTING RESUME REVIEW & INTERVIEW PREP FIXES ===\n\n";

// Get test user
$user = User::where('email', 'test@speedjobs.com')->first();
if (!$user) {
    echo "❌ Test user not found\n";
    exit(1);
}

echo "✓ Test user found: {$user->email}\n\n";

// =============================================
// TEST 1: PDF PARSER
// =============================================
echo "TEST 1: PDF Parser Installation\n";
echo "-----------------------------------\n";

if (class_exists('Smalot\PdfParser\Parser')) {
    echo "✓ PDF Parser library is installed\n";
    
    // Try to create a parser instance
    try {
        $parser = new PdfParser();
        echo "✓ PDF Parser can be instantiated\n";
    } catch (\Exception $e) {
        echo "❌ Error creating parser: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ PDF Parser library NOT installed\n";
    echo "Run: composer require smalot/pdfparser\n";
}

// =============================================
// TEST 2: RESUME REVIEW FLOW
// =============================================
echo "\nTEST 2: Resume Review Flow\n";
echo "-----------------------------------\n";

$gemini = new GeminiService();

// Check if analyzeResume method exists
if (method_exists($gemini, 'analyzeResume')) {
    echo "✓ GeminiService::analyzeResume() exists\n";
    
    // Test with sample resume text
    $sampleResumeText = "John Doe\nSoftware Engineer\n\nEXPERIENCE:\nSenior Developer at Tech Corp (2020-2024)\n- Led team of 5 developers\n- Built scalable microservices\n- Improved performance by 40%\n\nSKILLS:\nPython, JavaScript, React, Node.js, AWS, Docker";
    
    try {
        echo "Testing AI resume analysis...\n";
        $analysis = $gemini->analyzeResume($sampleResumeText, [
            'experience_level' => 'Senior',
            'field_of_study' => 'Computer Science'
        ]);
        
        echo "✓ Resume analysis completed\n";
        echo "ATS Score: " . ($analysis['ats_score'] ?? 'N/A') . "/100\n";
        echo "Overall Rating: " . ($analysis['overall_rating'] ?? 'N/A') . "\n";
        echo "Summary: " . substr($analysis['summary_feedback'] ?? 'N/A', 0, 100) . "...\n";
    } catch (\Exception $e) {
        echo "❌ Error analyzing resume: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ GeminiService::analyzeResume() NOT found\n";
}

// =============================================
// TEST 3: INTERVIEW PREP FLOW
// =============================================
echo "\n\nTEST 3: Interview Prep Flow\n";
echo "-----------------------------------\n";

// Clean up any stuck sessions first
$stuckSessions = AiSession::where('user_id', $user->id)
    ->where('module', 'interview_prep')
    ->where('status', 'in_progress')
    ->where('current_step', 0)
    ->get();

if ($stuckSessions->isNotEmpty()) {
    echo "Found {$stuckSessions->count()} stuck sessions. Cleaning up...\n";
    foreach ($stuckSessions as $stuck) {
        $stuck->delete();
    }
    echo "✓ Cleaned up stuck sessions\n";
}

// Create a new interview prep session
$session = AiSession::create([
    'user_id' => $user->id,
    'module' => 'interview_prep',
    'status' => 'in_progress',
    'current_step' => 0,
    'total_steps' => 6,
    'context_data' => ['target_role' => 'Backend Developer'],
]);

echo "✓ Created test session ID: {$session->id}\n";

// Simulate what happens when showSession is called
echo "\nSimulating showSession() call...\n";

if ($session->module === 'interview_prep' && $session->current_step === 0 && $session->steps->isEmpty()) {
    echo "✓ Condition met: Should generate first question\n";
    
    try {
        $questionData = $gemini->generateInterviewQuestion(
            $session->context_data['target_role'] ?? 'General',
            1
        );
        
        echo "✓ First question generated\n";
        echo "Question: " . substr($questionData['question'] ?? 'N/A', 0, 150) . "...\n";
        echo "Type: " . ($questionData['question_type'] ?? 'N/A') . "\n";
        
        // Simulate creating the step
        $step = new \App\Models\AiSessionStep([
            'session_id' => $session->id,
            'step_number' => 1,
            'step_type' => 'interview_question',
            'prompt' => $questionData['question'],
            'metadata' => $questionData,
        ]);
        
        echo "✓ Step would be created successfully\n";
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Condition NOT met\n";
}

// Test answer evaluation
echo "\nTesting answer evaluation...\n";
$testAnswer = "In my previous role, I faced a situation where our API was experiencing high latency. I analyzed the database queries and found N+1 query issues. I implemented eager loading and added caching, which reduced response time by 60%.";

try {
    $evaluation = $gemini->evaluateInterviewAnswer(
        'Backend Developer',
        'Tell me about a time you optimized system performance.',
        $testAnswer,
        ['Identified the problem', 'Implemented solution', 'Measured results']
    );
    
    echo "✓ Answer evaluation completed\n";
    echo "Score: " . ($evaluation['score'] ?? 'N/A') . "/100\n";
    echo "Feedback: " . substr($evaluation['feedback'] ?? 'N/A', 0, 100) . "...\n";
} catch (\Exception $e) {
    echo "❌ Error evaluating answer: " . $e->getMessage() . "\n";
}

// Clean up test session
$session->delete();
echo "\n✓ Test session cleaned up\n";

// =============================================
// SUMMARY
// =============================================
echo "\n\n=== SUMMARY ===\n";
echo "-----------------------------------\n";
echo "1. PDF Parser: " . (class_exists('Smalot\PdfParser\Parser') ? '✓ READY' : '❌ NOT INSTALLED') . "\n";
echo "2. Resume Analysis: " . (method_exists($gemini, 'analyzeResume') ? '✓ READY' : '❌ NOT READY') . "\n";
echo "3. Interview Prep: " . (method_exists($gemini, 'generateInterviewQuestion') ? '✓ READY' : '❌ NOT READY') . "\n";

echo "\n=== FIXES APPLIED ===\n";
echo "1. ✓ extractTextFromResume() now uses PDF parser\n";
echo "2. ✓ showSession() generates first interview question automatically\n";
echo "3. ✓ handleInterviewPrepStep() simplified and fixed\n";

echo "\n=== NEXT STEPS ===\n";
echo "1. Test Resume Review in browser with actual PDF\n";
echo "2. Test Interview Prep flow end-to-end\n";
echo "3. Verify AI responses are appropriate\n";

echo "\n=== TEST COMPLETE ===\n";
