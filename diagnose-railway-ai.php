<?php

/**
 * Railway AI Features Diagnostic Script
 * Run this on Railway to diagnose why AI features aren't working
 */

echo "=================================================================\n";
echo "RAILWAY AI FEATURES DIAGNOSTIC\n";
echo "=================================================================\n\n";

// Test 1: Check if we're running on Railway
echo "1. ENVIRONMENT CHECK\n";
echo "-------------------\n";
echo "APP_ENV: " . env('APP_ENV', 'not set') . "\n";
echo "APP_DEBUG: " . (env('APP_DEBUG') ? 'true' : 'false') . "\n";
echo "APP_URL: " . env('APP_URL', 'not set') . "\n";
echo "Railway Detected: " . (env('RAILWAY_ENVIRONMENT') ? 'YES' : 'NO') . "\n";
if (env('RAILWAY_ENVIRONMENT')) {
    echo "Railway Environment: " . env('RAILWAY_ENVIRONMENT') . "\n";
}
echo "\n";

// Test 2: Check Gemini API Key Configuration
echo "2. GEMINI API KEY CHECK\n";
echo "-----------------------\n";
$envKey = env('GEMINI_API_KEY');
$configKey = config('services.gemini.api_key');

echo "From env(): " . ($envKey ? substr($envKey, 0, 20) . '...' . substr($envKey, -10) : 'NOT SET') . "\n";
echo "From config(): " . ($configKey ? substr($configKey, 0, 20) . '...' . substr($configKey, -10) : 'NOT SET') . "\n";
echo "Key Length (env): " . ($envKey ? strlen($envKey) : 0) . " characters\n";
echo "Key Length (config): " . ($configKey ? strlen($configKey) : 0) . " characters\n";
echo "Keys Match: " . ($envKey === $configKey ? 'YES' : 'NO') . "\n";
echo "\n";

// Test 3: Check Other Gemini Config
echo "3. GEMINI CONFIGURATION\n";
echo "-----------------------\n";
echo "Model (env): " . env('GEMINI_MODEL', 'not set') . "\n";
echo "Model (config): " . config('services.gemini.model', 'not set') . "\n";
echo "Max Tokens: " . config('services.gemini.max_tokens', 'not set') . "\n";
echo "Temperature: " . config('services.gemini.temperature', 'not set') . "\n";
echo "\n";

// Test 4: Check if config is cached
echo "4. CONFIG CACHE CHECK\n";
echo "---------------------\n";
$configCached = file_exists(base_path('bootstrap/cache/config.php'));
echo "Config Cached: " . ($configCached ? 'YES (may need clearing)' : 'NO') . "\n";
if ($configCached) {
    echo "⚠️  WARNING: Cached config detected. Railway may need to run 'php artisan config:clear'\n";
}
echo "\n";

// Test 5: Try to initialize GeminiService
echo "5. GEMINI SERVICE INITIALIZATION\n";
echo "--------------------------------\n";
try {
    $gemini = app(\App\Services\GeminiService::class);
    echo "✓ GeminiService instantiated successfully\n";
    
    // Use reflection to check the API key in the service
    $reflection = new ReflectionClass($gemini);
    $property = $reflection->getProperty('apiKey');
    $property->setAccessible(true);
    $serviceApiKey = $property->getValue($gemini);
    
    echo "API Key in Service: " . ($serviceApiKey ? substr($serviceApiKey, 0, 20) . '...' . substr($serviceApiKey, -10) : 'NULL/EMPTY') . "\n";
    echo "Service Key Length: " . ($serviceApiKey ? strlen($serviceApiKey) : 0) . " characters\n";
    
} catch (Exception $e) {
    echo "✗ Error initializing GeminiService: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 6: Test actual API call
echo "6. GEMINI API CONNECTION TEST\n";
echo "------------------------------\n";
if (empty($configKey)) {
    echo "✗ SKIPPED: No API key configured\n";
} else {
    try {
        $response = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->timeout(10)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$configKey}", [
                'contents' => [
                    ['parts' => [['text' => 'Say "API Working" if you can read this.']]]
                ],
            ]);
        
        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No text in response';
            echo "✓ API Call Successful!\n";
            echo "Response: " . substr($text, 0, 100) . "\n";
        } else {
            echo "✗ API Call Failed\n";
            echo "Status: " . $response->status() . "\n";
            echo "Error: " . $response->body() . "\n";
        }
    } catch (Exception $e) {
        echo "✗ Exception during API call: " . $e->getMessage() . "\n";
    }
}
echo "\n";

// Test 7: Check Laravel HTTP Client Configuration
echo "7. HTTP CLIENT CHECK\n";
echo "--------------------\n";
echo "cURL Available: " . (function_exists('curl_version') ? 'YES' : 'NO') . "\n";
if (function_exists('curl_version')) {
    $curlVersion = curl_version();
    echo "cURL Version: " . $curlVersion['version'] . "\n";
    echo "SSL Version: " . $curlVersion['ssl_version'] . "\n";
}
echo "allow_url_fopen: " . (ini_get('allow_url_fopen') ? 'enabled' : 'disabled') . "\n";
echo "\n";

// Test 8: Check specific AI controller
echo "8. AI CONTROLLER CHECK\n";
echo "----------------------\n";
try {
    $controller = app(\App\Http\Controllers\CareerPathwayController::class);
    echo "✓ CareerPathwayController instantiated\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 9: Check database connection
echo "9. DATABASE CHECK\n";
echo "-----------------\n";
try {
    $dbConnection = \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "✓ Database connected\n";
    echo "Driver: " . \Illuminate\Support\Facades\DB::connection()->getDriverName() . "\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 10: Check logs for recent errors
echo "10. RECENT LOG ERRORS\n";
echo "---------------------\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentErrors = array_filter($lines, function($line) {
        return stripos($line, 'gemini') !== false || 
               stripos($line, 'api') !== false ||
               stripos($line, 'error') !== false;
    });
    $recentErrors = array_slice($recentErrors, -10);
    
    if (empty($recentErrors)) {
        echo "No recent Gemini-related errors found\n";
    } else {
        echo "Recent relevant log entries:\n";
        foreach ($recentErrors as $error) {
            echo "  " . substr($error, 0, 150) . "\n";
        }
    }
} else {
    echo "Log file not found at: {$logFile}\n";
}
echo "\n";

// Summary
echo "=================================================================\n";
echo "DIAGNOSTIC SUMMARY\n";
echo "=================================================================\n";

$issues = [];
if (empty($envKey)) $issues[] = "GEMINI_API_KEY not set in environment";
if (empty($configKey)) $issues[] = "GEMINI_API_KEY not loaded in config";
if ($envKey !== $configKey) $issues[] = "Environment and config keys don't match";
if ($configCached) $issues[] = "Config is cached (may be stale)";

if (empty($issues)) {
    echo "✓ No obvious configuration issues detected\n";
    echo "\nIf AI features still don't work, check:\n";
    echo "1. Railway deployment logs for errors\n";
    echo "2. Browser console for JavaScript errors\n";
    echo "3. Network tab for failed API requests\n";
} else {
    echo "✗ ISSUES FOUND:\n";
    foreach ($issues as $issue) {
        echo "  - {$issue}\n";
    }
    echo "\nRECOMMENDED FIXES:\n";
    if (empty($envKey)) {
        echo "1. Add GEMINI_API_KEY to Railway environment variables\n";
        echo "   Value: AIzaSyBhteNkDuny5GKMOKhsM1UqM1Zpbli6EcE\n";
    }
    if ($configCached) {
        echo "2. Clear config cache by adding to Railway start command:\n";
        echo "   php artisan config:clear && [rest of command]\n";
    }
}

echo "\n=================================================================\n";
