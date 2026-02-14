<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\GeminiService;
use App\Models\User;
use App\Models\AiConversation;

echo "🧪 AI COUNSELOR FEATURE TEST\n";
echo "============================\n\n";

// Test 1: Gemini Service Initialization
echo "1. GEMINI SERVICE TEST:\n";
try {
    $gemini = app(GeminiService::class);
    echo "   ✅ GeminiService initialized\n";
    
    $apiKey = config('services.gemini.api_key');
    if ($apiKey) {
        echo "   ✅ API Key configured: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n";
    } else {
        echo "   ❌ API Key NOT configured\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Simple AI Message
echo "2. AI MESSAGE TEST:\n";
try {
    $testPrompt = "Say 'Hello, I am working!' in exactly 5 words.";
    echo "   Sending test message: '$testPrompt'\n";
    
    $response = $gemini->sendMessage($testPrompt, [], []);
    
    if (isset($response['content']) && !empty($response['content'])) {
        echo "   ✅ AI Response received:\n";
        echo "   Response: " . substr($response['content'], 0, 100) . "...\n";
        
        if (isset($response['metadata'])) {
            echo "   Model: " . ($response['metadata']['model'] ?? 'unknown') . "\n";
            echo "   Processing time: " . ($response['metadata']['processing_time'] ?? 'unknown') . "s\n";
        }
    } else {
        echo "   ❌ No content in response\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Context-Aware Message
echo "3. CONTEXT-AWARE TEST:\n";
try {
    $userContext = [
        'name' => 'Test User',
        'university' => 'University of Lagos',
        'field_of_study' => 'Computer Science',
        'experience_level' => 'entry',
    ];
    
    $prompt = "What career advice do you have for me?";
    echo "   Sending with user context...\n";
    
    $response = $gemini->sendMessage($prompt, $userContext, []);
    
    if (isset($response['content']) && !empty($response['content'])) {
        echo "   ✅ Context-aware response received\n";
        echo "   Response length: " . strlen($response['content']) . " characters\n";
        
        // Check if response mentions user context
        $content = strtolower($response['content']);
        if (strpos($content, 'computer science') !== false || 
            strpos($content, 'lagos') !== false ||
            strpos($content, 'entry') !== false) {
            echo "   ✅ Response includes user context!\n";
        } else {
            echo "   ⚠️ Response may not include user context\n";
        }
    } else {
        echo "   ❌ No content in response\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Conversation History
echo "4. CONVERSATION HISTORY TEST:\n";
try {
    $history = [
        ['role' => 'user', 'content' => 'What is your name?'],
        ['role' => 'assistant', 'content' => 'I am your AI Career Counselor.'],
    ];
    
    $prompt = "What did I just ask you?";
    echo "   Sending with conversation history...\n";
    
    $response = $gemini->sendMessage($prompt, [], $history);
    
    if (isset($response['content']) && !empty($response['content'])) {
        echo "   ✅ History-aware response received\n";
        
        // Check if response references the previous question
        $content = strtolower($response['content']);
        if (strpos($content, 'name') !== false || strpos($content, 'asked') !== false) {
            echo "   ✅ Response shows conversation memory!\n";
        } else {
            echo "   ⚠️ Response may not reference history\n";
        }
    } else {
        echo "   ❌ No content in response\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Suggested Questions
echo "5. SUGGESTED QUESTIONS TEST:\n";
try {
    $history = [
        ['role' => 'user', 'content' => 'I want to become a software developer'],
        ['role' => 'assistant', 'content' => 'Great choice! Software development is a rewarding career.'],
    ];
    
    $userProfile = ['field_of_study' => 'Computer Science'];
    
    echo "   Generating suggested questions...\n";
    $suggestions = $gemini->getSuggestedQuestions($history, $userProfile);
    
    if (is_array($suggestions) && count($suggestions) > 0) {
        echo "   ✅ Suggestions generated: " . count($suggestions) . " questions\n";
        foreach ($suggestions as $i => $suggestion) {
            if (!empty($suggestion)) {
                echo "      " . ($i + 1) . ". " . substr($suggestion, 0, 60) . "...\n";
            }
        }
    } else {
        echo "   ⚠️ No suggestions generated\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Database Integration
echo "6. DATABASE INTEGRATION TEST:\n";
try {
    $user = User::where('email', 'test@speedjobs.com')->first();
    
    if ($user) {
        echo "   ✅ Test user found\n";
        
        // Create test conversation
        $conversation = $user->aiConversations()->create([
            'conversation_type' => 'career_advice',
            'status' => 'active',
            'context_data' => [
                'name' => $user->name,
                'field_of_study' => $user->field_of_study,
            ],
            'last_message_at' => now(),
        ]);
        
        echo "   ✅ Test conversation created (ID: {$conversation->id})\n";
        
        // Add test message
        $message = $conversation->messages()->create([
            'role' => 'user',
            'content' => 'This is a test message',
        ]);
        
        echo "   ✅ Test message created (ID: {$message->id})\n";
        
        // Add AI response
        $aiMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => 'This is a test AI response',
            'metadata' => ['test' => true],
        ]);
        
        echo "   ✅ AI message created (ID: {$aiMessage->id})\n";
        
        // Verify retrieval
        $retrieved = AiConversation::with('messages')->find($conversation->id);
        if ($retrieved && $retrieved->messages->count() === 2) {
            echo "   ✅ Messages retrieved successfully\n";
        } else {
            echo "   ❌ Message retrieval failed\n";
        }
        
        // Clean up
        $conversation->delete();
        echo "   ✅ Test data cleaned up\n";
        
    } else {
        echo "   ❌ Test user not found\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Advanced AI Methods
echo "7. ADVANCED AI METHODS TEST:\n";

// Test Resume Review
echo "   a) Resume Review:\n";
try {
    $resumeText = "John Doe\nSoftware Developer\nExperience: 2 years in web development";
    $review = $gemini->reviewResume($resumeText, null, []);
    
    if (!empty($review)) {
        echo "      ✅ Resume review generated (" . strlen($review) . " chars)\n";
    } else {
        echo "      ❌ Resume review failed\n";
    }
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

// Test Interview Questions
echo "   b) Interview Questions:\n";
try {
    $questions = $gemini->generateInterviewQuestions('Software Developer', 'entry', 3);
    
    if (is_array($questions) && count($questions) > 0) {
        echo "      ✅ Interview questions generated: " . count($questions) . " questions\n";
    } else {
        echo "      ❌ Interview questions failed\n";
    }
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

// Test Career Pathway
echo "   c) Career Pathway:\n";
try {
    $pathway = $gemini->generateCareerPathway('Senior Developer', ['field_of_study' => 'Computer Science'], 'Junior Developer');
    
    if (is_array($pathway) && isset($pathway['raw_content'])) {
        echo "      ✅ Career pathway generated\n";
    } else {
        echo "      ❌ Career pathway failed\n";
    }
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Summary
echo "📋 TEST SUMMARY:\n";
echo "================\n";
echo "✅ = Working correctly\n";
echo "⚠️  = Working but with warnings\n";
echo "❌ = Not working\n\n";

echo "If all tests show ✅, your AI Counselor is fully functional!\n";
echo "If you see ❌, check the error messages above.\n\n";

echo "🎉 Testing complete!\n";
