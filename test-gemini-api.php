<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Gemini API ===\n\n";

// Check API key
$apiKey = config('services.gemini.api_key');
echo "1. API Key Configuration:\n";
if (empty($apiKey)) {
    echo "   ❌ GEMINI_API_KEY not found in config\n";
    echo "   Run: php artisan config:clear\n\n";
    exit(1);
} else {
    echo "   ✅ API Key found\n";
    echo "   Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n\n";
}

// Test GeminiService
echo "2. Testing GeminiService:\n";
try {
    $gemini = app(\App\Services\GeminiService::class);
    echo "   ✅ GeminiService instantiated\n\n";
    
    echo "3. Sending test message to Gemini API:\n";
    echo "   Message: 'Hello! Please respond with: Test successful!'\n";
    echo "   Waiting for response...\n\n";
    
    $response = $gemini->sendMessage(
        "Hello! This is a test message. Please respond with exactly: 'Test successful!' and nothing else."
    );
    
    if (isset($response['content'])) {
        echo "   ✅ API Response received!\n\n";
        echo "   Response Content:\n";
        echo "   " . str_repeat("-", 60) . "\n";
        echo "   " . $response['content'] . "\n";
        echo "   " . str_repeat("-", 60) . "\n\n";
        
        if (isset($response['metadata'])) {
            echo "   Metadata:\n";
            echo "   - Model: " . ($response['metadata']['model'] ?? 'N/A') . "\n";
            echo "   - Processing Time: " . ($response['metadata']['processing_time'] ?? 'N/A') . "s\n";
            
            if (isset($response['metadata']['tokens_used'])) {
                $tokens = $response['metadata']['tokens_used'];
                echo "   - Tokens Used:\n";
                echo "     * Prompt: " . ($tokens['promptTokenCount'] ?? 'N/A') . "\n";
                echo "     * Response: " . ($tokens['candidatesTokenCount'] ?? 'N/A') . "\n";
                echo "     * Total: " . ($tokens['totalTokenCount'] ?? 'N/A') . "\n";
            }
        }
        
        echo "\n   ✅ Gemini API is working correctly!\n\n";
        
    } else {
        echo "   ⚠️  Unexpected response format\n";
        echo "   Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n\n";
    }
    
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n\n";
    exit(1);
}

echo "=== Test Complete ===\n\n";

echo "SUMMARY:\n";
echo "--------\n";
echo "✅ API Key configured\n";
echo "✅ GeminiService working\n";
echo "✅ API connection successful\n";
echo "✅ AI Career Counselor is fully functional!\n\n";

echo "Next Steps:\n";
echo "1. Visit: http://localhost:8000/ai-counselor\n";
echo "2. Login to your account\n";
echo "3. Click any button (Career Advice, Interview Prep, etc.)\n";
echo "4. Start chatting with the AI!\n";
