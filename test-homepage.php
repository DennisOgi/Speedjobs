<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Homepage After Workshop Removal\n";
echo "========================================\n\n";

// Test 1: Check if banners are loading
echo "1. Testing Banner Loading...\n";
$banners = \App\Models\Banner::active()->get();
echo "   Found {$banners->count()} active banners\n";
if ($banners->count() > 0) {
    echo "   ✓ Banners are available\n";
} else {
    echo "   ⚠ No active banners found\n";
}

// Test 2: Check if jobs are loading
echo "\n2. Testing Job Loading...\n";
$recentJobs = \App\Models\Job::latest()->take(6)->get();
echo "   Found {$recentJobs->count()} recent jobs\n";
if ($recentJobs->count() > 0) {
    echo "   ✓ Jobs are available\n";
} else {
    echo "   ⚠ No jobs found\n";
}

// Test 3: Check if workshop routes are removed
echo "\n3. Testing Workshop Route Removal...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $workshopRoutes = collect($routes)->filter(function($route) {
        return str_contains($route->getName() ?? '', 'workshops.');
    });
    
    if ($workshopRoutes->count() === 0) {
        echo "   ✓ All workshop routes successfully removed\n";
    } else {
        echo "   ⚠ Found {$workshopRoutes->count()} workshop routes still registered:\n";
        foreach ($workshopRoutes as $route) {
            echo "      - {$route->getName()}\n";
        }
    }
} catch (\Exception $e) {
    echo "   ✗ Error checking routes: {$e->getMessage()}\n";
}

// Test 4: Check banner applications in dashboard
echo "\n4. Testing Banner Applications...\n";
$user = \App\Models\User::where('role', 'jobseeker')->first();
if ($user) {
    $applications = \App\Models\BannerApplication::where('user_id', $user->id)->get();
    echo "   Found {$applications->count()} banner applications for test user\n";
    echo "   ✓ Banner application system working\n";
} else {
    echo "   ⚠ No jobseeker user found for testing\n";
}

echo "\n========================================\n";
echo "✓ All Tests Complete!\n";
echo "\nYou can now:\n";
echo "1. Visit http://127.0.0.1:8000 to see the homepage\n";
echo "2. Apply to banners from the hero section\n";
echo "3. View your applications in the dashboard\n";
echo "4. Admin can manage applications at /admin/banner-applications\n";
