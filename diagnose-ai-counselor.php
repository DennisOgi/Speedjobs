<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== AI Career Counselor Diagnostics ===\n\n";

// 1. Check Database Connection
echo "1. Database Connection:\n";
try {
    DB::connection()->getPdo();
    echo "   ✅ Database connected successfully\n";
    echo "   Database: " . DB::connection()->getDatabaseName() . "\n\n";
} catch (\Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 2. Check if migrations are run
echo "2. Database Tables:\n";
$tables = [
    'ai_conversations',
    'ai_messages',
    'assessment_results',
    'career_pathways',
    'ai_feedback'
];

foreach ($tables as $table) {
    try {
        DB::table($table)->count();
        echo "   ✅ Table '{$table}' exists\n";
    } catch (\Exception $e) {
        echo "   ❌ Table '{$table}' missing - Run: php artisan migrate\n";
    }
}
echo "\n";

// 3. Check Gemini API Key
echo "3. Gemini API Configuration:\n";
$apiKey = config('services.gemini.api_key');
if (empty($apiKey)) {
    echo "   ⚠️  GEMINI_API_KEY not configured in .env\n";
    echo "   Add: GEMINI_API_KEY=your_key_here\n";
} else {
    echo "   ✅ GEMINI_API_KEY is configured\n";
    echo "   Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n";
}
echo "   Model: " . config('services.gemini.model', 'not set') . "\n\n";

// 4. Check Routes
echo "4. AI Counselor Routes:\n";
try {
    $routes = Route::getRoutes();
    $aiRoutes = [];
    foreach ($routes as $route) {
        if (str_contains($route->getName() ?? '', 'ai-counselor')) {
            $aiRoutes[] = $route->getName();
        }
    }
    echo "   ✅ Found " . count($aiRoutes) . " AI counselor routes\n";
    foreach ($aiRoutes as $routeName) {
        echo "      - {$routeName}\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking routes: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Check Users
echo "5. User Accounts:\n";
try {
    $totalUsers = DB::table('users')->count();
    $paidUsers = DB::table('users')->where('is_paid', 1)->count();
    echo "   Total users: {$totalUsers}\n";
    echo "   Premium users: {$paidUsers}\n";
    
    if ($paidUsers === 0) {
        echo "   ⚠️  No premium users found\n";
        echo "   To make a user premium, run:\n";
        echo "   UPDATE users SET is_paid = 1 WHERE email = 'your@email.com';\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking users: " . $e->getMessage() . "\n";
}
echo "\n";

// 6. Check existing conversations
echo "6. Existing Conversations:\n";
try {
    $conversations = DB::table('ai_conversations')->count();
    $messages = DB::table('ai_messages')->count();
    echo "   Conversations: {$conversations}\n";
    echo "   Messages: {$messages}\n";
} catch (\Exception $e) {
    echo "   ❌ Error checking conversations: " . $e->getMessage() . "\n";
}
echo "\n";

// 7. Test Gemini Service
echo "7. Gemini Service Test:\n";
try {
    $gemini = app(\App\Services\GeminiService::class);
    echo "   ✅ GeminiService instantiated successfully\n";
    
    if (!empty($apiKey)) {
        echo "   Testing API connection...\n";
        $response = $gemini->sendMessage("Hello, this is a test message. Please respond with 'Test successful!'");
        
        if (isset($response['content'])) {
            echo "   ✅ API Response received\n";
            echo "   Response: " . substr($response['content'], 0, 100) . "...\n";
        } else {
            echo "   ⚠️  API Response format unexpected\n";
        }
    } else {
        echo "   ⚠️  Skipping API test (no API key configured)\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error testing Gemini service: " . $e->getMessage() . "\n";
}
echo "\n";

// 8. Check middleware
echo "8. Middleware Configuration:\n";
try {
    $route = Route::getRoutes()->getByName('ai-counselor.create');
    if ($route) {
        $middleware = $route->middleware();
        echo "   Route: ai-counselor.create\n";
        echo "   Middleware: " . implode(', ', $middleware) . "\n";
        
        if (!in_array('auth', $middleware)) {
            echo "   ⚠️  'auth' middleware not applied (routes are public)\n";
        }
        if (!in_array('paid', $middleware)) {
            echo "   ⚠️  'paid' middleware not applied (not premium-only)\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking middleware: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Diagnostics Complete ===\n\n";

echo "SUMMARY:\n";
echo "--------\n";
echo "If all checks passed, the AI Career Counselor should be working.\n";
echo "If buttons aren't working, check:\n";
echo "1. Are you logged in?\n";
echo "2. Is JavaScript enabled in your browser?\n";
echo "3. Check browser console for errors (F12)\n";
echo "4. Check Laravel logs: storage/logs/laravel.log\n";
