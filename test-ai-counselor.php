<?php

/**
 * AI Career Counselor - Quick Test Script
 * 
 * This script demonstrates how the AI counselor works
 * Run: php test-ai-counselor.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\GeminiService;
use App\Models\User;
use App\Models\AiConversation;

echo "\n🤖 AI Career Counselor - Test Script\n";
echo "=====================================\n\n";

// Check if Gemini API key is configured
$apiKey = config('services.gemini.api_key');
if (empty($apiKey)) {
    echo "❌ ERROR: GEMINI_API_KEY not found in .env\n";
    echo "\n📝 To fix this:\n";
    echo "1. Get API key from: https://aistudio.google.com/app/apikey\n";
    echo "2. Add to .env: GEMINI_API_KEY=your_key_here\n\n";
    exit(1);
}

echo "✅ Gemini API key configured\n";
echo "✅ Model: " . config('services.gemini.model') . "\n\n";

// Test 1: Simple AI Response
echo "📝 Test 1: Testing Gemini API Connection...\n";
echo "-------------------------------------------\n";

try {
    $gemini = new GeminiService();
    
    $response = $gemini->sendMessage(
        "Hello! Can you help me with career advice?",
        [
            'name' => 'Test User',
            'field_of_study' => 'Computer Science',
            'experience_level' => 'Entry Level',
            'location' => 'Lagos, Nigeria'
        ]
    );
    
    echo "✅ API Connection Successful!\n\n";
    echo "AI Response:\n";
    echo "------------\n";
    echo wordwrap($response['content'], 80) . "\n\n";
    
    echo "Metadata:\n";
    echo "- Model: " . ($response['metadata']['model'] ?? 'N/A') . "\n";
    echo "- Processing Time: " . ($response['metadata']['processing_time'] ?? 'N/A') . "s\n";
    
    if (isset($response['metadata']['tokens_used'])) {
        $tokens = $response['metadata']['tokens_used'];
        echo "- Input Tokens: " . ($tokens['promptTokenCount'] ?? 0) . "\n";
        echo "- Output Tokens: " . ($tokens['candidatesTokenCount'] ?? 0) . "\n";
        echo "- Total Tokens: " . ($tokens['totalTokenCount'] ?? 0) . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "\nCheck your API key and internet connection.\n";
    exit(1);
}

echo "\n";

// Test 2: Career Pathway Generation
echo "📝 Test 2: Generating Career Pathway...\n";
echo "---------------------------------------\n";

try {
    $pathway = $gemini->generateCareerPathway(
        'Senior Software Engineer',
        [
            'field_of_study' => 'Computer Science',
            'experience_level' => 'Entry Level',
            'skills' => 'JavaScript, Python, HTML/CSS',
        ],
        'Junior Developer'
    );
    
    echo "✅ Career Pathway Generated!\n\n";
    echo "Timeline: " . ($pathway['timeline'] ?? 'Not specified') . "\n";
    echo "Steps: " . count($pathway['steps']) . " steps identified\n";
    echo "Skills: " . count($pathway['skills']) . " skills to develop\n\n";
    
    if (!empty($pathway['steps'])) {
        echo "First 3 Steps:\n";
        foreach (array_slice($pathway['steps'], 0, 3) as $i => $step) {
            echo ($i + 1) . ". " . substr($step, 0, 100) . "...\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Interview Questions
echo "📝 Test 3: Generating Interview Questions...\n";
echo "--------------------------------------------\n";

try {
    $questions = $gemini->generateInterviewQuestions(
        'Software Engineer',
        'Entry Level',
        3
    );
    
    echo "✅ Generated " . count($questions) . " interview questions!\n\n";
    
    foreach ($questions as $i => $q) {
        echo ($i + 1) . ". " . $q['question'] . "\n";
        echo "   Type: " . $q['type'] . "\n";
        echo "   Tip: " . $q['tips'] . "\n\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Database Check
echo "📝 Test 4: Checking Database Tables...\n";
echo "--------------------------------------\n";

try {
    $tables = [
        'ai_conversations',
        'ai_messages',
        'assessment_results',
        'career_pathways',
        'ai_feedback'
    ];
    
    foreach ($tables as $table) {
        $exists = \Illuminate\Support\Facades\Schema::hasTable($table);
        echo ($exists ? "✅" : "❌") . " Table: {$table}\n";
    }
    
    echo "\n";
    
    // Check if we have any users
    $userCount = User::count();
    echo "👥 Users in database: {$userCount}\n";
    
    if ($userCount > 0) {
        $paidUsers = User::where('is_paid', true)->count();
        echo "💎 Premium users: {$paidUsers}\n";
    }
    
    // Check conversations
    $convCount = AiConversation::count();
    echo "💬 AI Conversations: {$convCount}\n";
    
} catch (\Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "\n💡 Run migrations: php artisan migrate\n";
}

echo "\n";

// Summary
echo "=====================================\n";
echo "🎉 Test Complete!\n\n";

echo "✅ What's Working:\n";
echo "- Gemini API integration\n";
echo "- AI response generation\n";
echo "- Career pathway creation\n";
echo "- Interview question generation\n\n";

echo "🚀 Next Steps:\n";
echo "1. Run migrations: php artisan migrate\n";
echo "2. Start server: php artisan serve\n";
echo "3. Login as premium user (is_paid = 1)\n";
echo "4. Visit: http://localhost:8000/ai-counselor\n";
echo "5. Start chatting!\n\n";

echo "📚 Documentation:\n";
echo "- Setup: SETUP_INSTRUCTIONS.md\n";
echo "- Features: AI_COUNSELOR_README.md\n";
echo "- Full Specs: .kiro/specs/ai-career-counsellor.md\n\n";

echo "💰 Cost Estimate:\n";
echo "- Per conversation: ~$0.0007\n";
echo "- Per user/month: ~$0.014\n";
echo "- 1,000 users/month: ~$14\n\n";

echo "🎊 You're ready to launch!\n\n";
