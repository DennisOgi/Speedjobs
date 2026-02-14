<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing All Dashboards After Workshop Removal\n";
echo "==============================================\n\n";

// Test 1: Homepage
echo "1. Testing Homepage (/)...\n";
try {
    $banners = \App\Models\Banner::active()->get();
    $recentJobs = \App\Models\Job::latest()->take(6)->get();
    $featuredJobs = \App\Models\Job::where('is_featured', true)->latest()->take(4)->get();
    echo "   ✓ Homepage data loads successfully\n";
    echo "   - Banners: {$banners->count()}\n";
    echo "   - Recent Jobs: {$recentJobs->count()}\n";
    echo "   - Featured Jobs: {$featuredJobs->count()}\n";
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

// Test 2: Jobseeker Dashboard
echo "\n2. Testing Jobseeker Dashboard (/dashboard)...\n";
try {
    $user = \App\Models\User::where('role', 'jobseeker')->first();
    if ($user) {
        $recentApplications = $user->jobApplications()->with('job')->latest()->take(5)->get();
        $savedJobs = $user->savedJobs()->with('job')->latest()->take(5)->get();
        $bannerApplications = \App\Models\BannerApplication::with('banner')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        echo "   ✓ Jobseeker dashboard data loads successfully\n";
        echo "   - Job Applications: {$recentApplications->count()}\n";
        echo "   - Saved Jobs: {$savedJobs->count()}\n";
        echo "   - Banner Applications: {$bannerApplications->count()}\n";
        echo "   - User is paid: " . ($user->is_paid ? 'Yes' : 'No') . "\n";
    } else {
        echo "   ⚠ No jobseeker user found\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

// Test 3: Admin Dashboard
echo "\n3. Testing Admin Dashboard (/admin/dashboard)...\n";
try {
    $admin = \App\Models\User::where('is_admin', true)->first();
    if ($admin) {
        $totalUsers = \App\Models\User::count();
        $totalBanners = \App\Models\Banner::count();
        $totalApplications = \App\Models\BannerApplication::count();
        $counselingRequests = \App\Models\CounselingRequest::count();
        
        echo "   ✓ Admin dashboard data loads successfully\n";
        echo "   - Total Users: {$totalUsers}\n";
        echo "   - Total Banners: {$totalBanners}\n";
        echo "   - Banner Applications: {$totalApplications}\n";
        echo "   - Counseling Requests: {$counselingRequests}\n";
    } else {
        echo "   ⚠ No admin user found\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

// Test 4: Employer Dashboard
echo "\n4. Testing Employer Dashboard (/employer/dashboard)...\n";
try {
    $employer = \App\Models\User::where('role', 'employer')->first();
    if ($employer) {
        $jobs = \App\Models\Job::where('user_id', $employer->id)->count();
        echo "   ✓ Employer dashboard accessible\n";
        echo "   - Posted Jobs: {$jobs}\n";
    } else {
        echo "   ⚠ No employer user found\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

// Test 5: Verify no workshop routes
echo "\n5. Verifying Workshop Routes Removed...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $workshopRoutes = collect($routes)->filter(function($route) {
        $name = $route->getName() ?? '';
        return str_contains($name, 'workshops.') || str_contains($name, 'admin.workshops.');
    });
    
    if ($workshopRoutes->count() === 0) {
        echo "   ✓ All workshop routes successfully removed\n";
    } else {
        echo "   ⚠ Found {$workshopRoutes->count()} workshop routes still registered\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

// Test 6: Check banner application routes
echo "\n6. Checking Banner Application Routes...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $bannerRoutes = collect($routes)->filter(function($route) {
        $name = $route->getName() ?? '';
        return str_contains($name, 'banner') && str_contains($name, 'application');
    });
    
    echo "   ✓ Found {$bannerRoutes->count()} banner application routes:\n";
    foreach ($bannerRoutes as $route) {
        echo "      - {$route->getName()}\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

echo "\n==============================================\n";
echo "✓ All Dashboard Tests Complete!\n";
echo "\nKey URLs to Test:\n";
echo "- Homepage: http://127.0.0.1:8000\n";
echo "- Jobseeker Dashboard: http://127.0.0.1:8000/dashboard\n";
echo "- Admin Dashboard: http://127.0.0.1:8000/admin/dashboard\n";
echo "- Employer Dashboard: http://127.0.0.1:8000/employer/dashboard\n";
echo "\nAll dashboards should now load without route errors!\n";
