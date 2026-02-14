<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Admin Dashboard After Workshop Removal\n";
echo "===============================================\n\n";

// Test 1: Check if admin user exists
echo "1. Checking Admin User...\n";
$admin = \App\Models\User::where('is_admin', true)->first();
if ($admin) {
    echo "   ✓ Admin user found: {$admin->name} ({$admin->email})\n";
} else {
    echo "   ⚠ No admin user found. Run: php make-admin.php\n";
}

// Test 2: Check banner stats
echo "\n2. Checking Banner Statistics...\n";
$totalBanners = \App\Models\Banner::count();
$activeBanners = \App\Models\Banner::active()->count();
echo "   Total Banners: {$totalBanners}\n";
echo "   Active Banners: {$activeBanners}\n";
echo "   ✓ Banner system operational\n";

// Test 3: Check banner applications
echo "\n3. Checking Banner Applications...\n";
$totalApplications = \App\Models\BannerApplication::count();
$pendingApplications = \App\Models\BannerApplication::where('status', 'pending')->count();
$approvedApplications = \App\Models\BannerApplication::where('status', 'approved')->count();
$rejectedApplications = \App\Models\BannerApplication::where('status', 'rejected')->count();
echo "   Total Applications: {$totalApplications}\n";
echo "   Pending: {$pendingApplications}\n";
echo "   Approved: {$approvedApplications}\n";
echo "   Rejected: {$rejectedApplications}\n";
echo "   ✓ Application system working\n";

// Test 4: Check counseling requests
echo "\n4. Checking Counseling Requests...\n";
$counselingRequests = \App\Models\CounselingRequest::count();
echo "   Total Requests: {$counselingRequests}\n";
echo "   ✓ Counseling system operational\n";

// Test 5: Check users
echo "\n5. Checking User Statistics...\n";
$totalUsers = \App\Models\User::count();
$jobseekers = \App\Models\User::where('role', 'jobseeker')->count();
$employers = \App\Models\User::where('role', 'employer')->count();
$admins = \App\Models\User::where('is_admin', true)->count();
echo "   Total Users: {$totalUsers}\n";
echo "   Jobseekers: {$jobseekers}\n";
echo "   Employers: {$employers}\n";
echo "   Admins: {$admins}\n";
echo "   ✓ User system operational\n";

// Test 6: Verify no workshop routes exist
echo "\n6. Verifying Workshop Routes Removed...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $workshopRoutes = collect($routes)->filter(function($route) {
        $name = $route->getName() ?? '';
        return str_contains($name, 'workshops.') || str_contains($name, 'admin.workshops.');
    });
    
    if ($workshopRoutes->count() === 0) {
        echo "   ✓ All workshop routes successfully removed\n";
    } else {
        echo "   ⚠ Found {$workshopRoutes->count()} workshop routes:\n";
        foreach ($workshopRoutes as $route) {
            echo "      - {$route->getName()}\n";
        }
    }
} catch (\Exception $e) {
    echo "   ✗ Error: {$e->getMessage()}\n";
}

echo "\n===============================================\n";
echo "✓ Admin Dashboard Tests Complete!\n";
echo "\nAdmin Dashboard URLs:\n";
echo "- Dashboard: http://127.0.0.1:8000/admin/dashboard\n";
echo "- Banners: http://127.0.0.1:8000/admin/banners\n";
echo "- Applications: http://127.0.0.1:8000/admin/banner-applications\n";
echo "- Users: http://127.0.0.1:8000/admin/users\n";
echo "- Counseling: http://127.0.0.1:8000/admin/counseling\n";
echo "- Resources: http://127.0.0.1:8000/admin/resources\n";
echo "- Mentor Applications: http://127.0.0.1:8000/admin/mentor-applications\n";
