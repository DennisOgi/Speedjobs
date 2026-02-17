<?php

use Illuminate\Support\Facades\Route;

/**
 * Diagnostic route for Railway - accessible at /diagnostic-check
 * This helps identify configuration issues on production
 */
Route::get('/diagnostic-check', function () {
    $diagnostics = [];
    
    // 1. Check environment
    $diagnostics['environment'] = [
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG') ? 'true' : 'false',
        'RAILWAY_ENVIRONMENT' => env('RAILWAY_ENVIRONMENT', 'not detected'),
    ];
    
    // 2. Check Gemini API Key
    $envKey = env('GEMINI_API_KEY');
    $configKey = config('services.gemini.api_key');
    
    $diagnostics['gemini_config'] = [
        'env_key_set' => !empty($envKey),
        'env_key_length' => $envKey ? strlen($envKey) : 0,
        'config_key_set' => !empty($configKey),
        'config_key_length' => $configKey ? strlen($configKey) : 0,
        'keys_match' => $envKey === $configKey,
        'model' => config('services.gemini.model'),
    ];
    
    // 3. Check if config is cached
    $diagnostics['config_cache'] = [
        'cached' => file_exists(base_path('bootstrap/cache/config.php')),
        'cache_path' => base_path('bootstrap/cache/config.php'),
    ];
    
    // 4. Test GeminiService initialization
    try {
        $gemini = app(\App\Services\GeminiService::class);
        $reflection = new ReflectionClass($gemini);
        $property = $reflection->getProperty('apiKey');
        $property->setAccessible(true);
        $serviceApiKey = $property->getValue($gemini);
        
        $diagnostics['gemini_service'] = [
            'initialized' => true,
            'api_key_in_service' => !empty($serviceApiKey),
            'api_key_length' => $serviceApiKey ? strlen($serviceApiKey) : 0,
        ];
    } catch (Exception $e) {
        $diagnostics['gemini_service'] = [
            'initialized' => false,
            'error' => $e->getMessage(),
        ];
    }
    
    // 5. Test actual API call (only if key exists)
    if (!empty($configKey)) {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->timeout(10)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$configKey}", [
                    'contents' => [['parts' => [['text' => 'Reply with: API Working']]]]
                ]);
            
            $diagnostics['api_test'] = [
                'success' => $response->successful(),
                'status' => $response->status(),
                'response_preview' => $response->successful() ? 
                    substr($response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'No text', 0, 50) : 
                    substr($response->body(), 0, 200),
            ];
        } catch (Exception $e) {
            $diagnostics['api_test'] = [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    } else {
        $diagnostics['api_test'] = [
            'skipped' => 'No API key configured',
        ];
    }
    
    // 6. Summary
    $issues = [];
    if (empty($envKey)) $issues[] = 'GEMINI_API_KEY not set in environment variables';
    if (empty($configKey)) $issues[] = 'GEMINI_API_KEY not loaded in config';
    if ($envKey !== $configKey) $issues[] = 'Environment and config keys do not match';
    if (file_exists(base_path('bootstrap/cache/config.php'))) $issues[] = 'Config is cached (may contain stale values)';
    
    $diagnostics['summary'] = [
        'status' => empty($issues) ? 'OK' : 'ISSUES FOUND',
        'issues' => $issues,
        'recommendation' => empty($issues) ? 
            'Configuration looks good' : 
            'Add GEMINI_API_KEY to Railway environment variables and redeploy',
    ];
    
    return response()->json($diagnostics, 200, [], JSON_PRETTY_PRINT);
});
