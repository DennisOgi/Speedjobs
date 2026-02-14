<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Banner;
use App\Models\User;

echo "🔍 DIAGNOSTIC REPORT\n";
echo "===================\n\n";

// Check 1: Banners
echo "1. BANNER CHECK:\n";
echo "   Total banners: " . Banner::count() . "\n";
echo "   Active banners: " . Banner::where('is_active', true)->count() . "\n";

$banners = Banner::active()->get();
if ($banners->count() > 0) {
    echo "   ✅ Banners exist and are active\n";
    foreach ($banners as $banner) {
        echo "      - {$banner->title}\n";
    }
} else {
    echo "   ❌ No active banners found\n";
}

echo "\n";

// Check 2: Test User
echo "2. TEST USER CHECK:\n";
$testUser = User::where('email', 'test@speedjobs.com')->first();
if ($testUser) {
    echo "   ✅ Test user exists\n";
    echo "   Email: {$testUser->email}\n";
    echo "   Name: {$testUser->name}\n";
    echo "   Premium: " . ($testUser->is_paid ? 'YES ✅' : 'NO ❌') . "\n";
    echo "   Role: {$testUser->role}\n";
} else {
    echo "   ❌ Test user not found\n";
}

echo "\n";

// Check 3: Routes
echo "3. ROUTE CHECK:\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $aiRoutes = collect($routes)->filter(function($route) {
        return str_contains($route->getName() ?? '', 'ai-counselor');
    });
    
    echo "   AI Counselor routes found: " . $aiRoutes->count() . "\n";
    if ($aiRoutes->count() > 0) {
        echo "   ✅ AI Counselor routes are registered\n";
        foreach ($aiRoutes as $route) {
            echo "      - " . $route->getName() . " → " . $route->uri() . "\n";
        }
    } else {
        echo "   ❌ No AI Counselor routes found\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking routes: " . $e->getMessage() . "\n";
}

echo "\n";

// Check 4: Gemini API
echo "4. GEMINI API CHECK:\n";
$apiKey = config('services.gemini.api_key');
if ($apiKey) {
    echo "   ✅ Gemini API key is configured\n";
    echo "   Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n";
    echo "   Model: " . config('services.gemini.model') . "\n";
} else {
    echo "   ❌ Gemini API key is NOT configured\n";
}

echo "\n";

// Check 5: Database Connection
echo "5. DATABASE CHECK:\n";
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "   ✅ Database connection successful\n";
    echo "   Driver: " . config('database.default') . "\n";
    echo "   Database: " . config('database.connections.' . config('database.default') . '.database') . "\n";
} catch (\Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Summary
echo "📋 SUMMARY:\n";
echo "===========\n";
echo "Banners: " . (Banner::active()->count() > 0 ? '✅ Working' : '❌ Not working') . "\n";
echo "Test User: " . ($testUser && $testUser->is_paid ? '✅ Ready' : '❌ Not ready') . "\n";
echo "AI Routes: " . ($aiRoutes->count() > 0 ? '✅ Registered' : '❌ Missing') . "\n";
echo "Gemini API: " . ($apiKey ? '✅ Configured' : '❌ Not configured') . "\n";
echo "Database: ✅ Connected\n";

echo "\n";

// Instructions
echo "📝 NEXT STEPS:\n";
echo "==============\n";

if (Banner::active()->count() === 0) {
    echo "1. Run: php artisan db:seed --class=BannerSeeder\n";
}

if (!$testUser || !$testUser->is_paid) {
    echo "2. Run: php create-test-user.php\n";
}

if (!$apiKey) {
    echo "3. Add GEMINI_API_KEY to your .env file\n";
}

echo "\n4. Restart your server: php artisan serve\n";
echo "5. Visit: http://127.0.0.1:8000\n";
echo "6. Login with: test@speedjobs.com / password\n";
echo "7. Click on 'Career Services' → 'AI Career Counselor'\n";

echo "\n✅ Diagnostic complete!\n";
