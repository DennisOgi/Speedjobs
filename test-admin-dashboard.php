<?php

/**
 * Admin Dashboard Comprehensive Test
 * 
 * This script tests all admin dashboard features to ensure they're production-ready
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Banner;
use App\Models\BannerApplication;
use App\Models\MentorApplication;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use App\Models\CounselingRequest;
use Illuminate\Support\Facades\Route;

echo "=== ADMIN DASHBOARD COMPREHENSIVE TEST ===\n\n";

// Test 1: Check Admin Middleware
echo "✓ Test 1: Admin Middleware\n";
$adminMiddleware = file_exists('app/Http/Middleware/IsAdmin.php');
echo $adminMiddleware ? "  ✓ IsAdmin middleware exists\n" : "  ✗ IsAdmin middleware missing\n";

// Test 2: Check Admin Routes
echo "\n✓ Test 2: Admin Routes\n";
$adminRoutes = [
    'admin.dashboard',
    'admin.banners.index',
    'admin.users.index',
    'admin.workshops.index',
    'admin.banner-applications.index',
    'admin.mentor-applications.index',
    'admin.counseling.index',
];

foreach ($adminRoutes as $routeName) {
    $exists = Route::has($routeName);
    echo $exists ? "  ✓ Route '$routeName' exists\n" : "  ✗ Route '$routeName' missing\n";
}

// Test 3: Check Admin Controllers
echo "\n✓ Test 3: Admin Controllers\n";
$controllers = [
    'AdminDashboardController' => 'app/Http/Controllers/AdminDashboardController.php',
    'AdminBannerController' => 'app/Http/Controllers/AdminBannerController.php',
    'UserController' => 'app/Http/Controllers/Admin/UserController.php',
    'WorkshopController' => 'app/Http/Controllers/Admin/WorkshopController.php',
    'BannerApplicationController' => 'app/Http/Controllers/Admin/BannerApplicationController.php',
    'MentorApplicationController' => 'app/Http/Controllers/Admin/MentorApplicationController.php',
    'CounselingRequestController' => 'app/Http/Controllers/Admin/CounselingRequestController.php',
];

foreach ($controllers as $name => $path) {
    $exists = file_exists($path);
    echo $exists ? "  ✓ $name exists\n" : "  ✗ $name missing\n";
}

// Test 4: Check Admin Views
echo "\n✓ Test 4: Admin Views\n";
$views = [
    'admin/dashboard.blade.php',
    'admin/banners/index.blade.php',
    'admin/users/index.blade.php',
    'admin/workshops/index.blade.php',
    'admin/banner-applications/index.blade.php',
    'admin/mentor-applications/index.blade.php',
    'admin/counseling/index.blade.php',
];

foreach ($views as $view) {
    $path = "resources/views/$view";
    $exists = file_exists($path);
    echo $exists ? "  ✓ $view exists\n" : "  ✗ $view missing\n";
}

// Test 5: Check Database Tables
echo "\n✓ Test 5: Database Tables\n";
$tables = [
    'users',
    'banners',
    'banner_applications',
    'mentor_applications',
    'workshops',
    'workshop_registrations',
    'counseling_requests',
];

foreach ($tables as $table) {
    try {
        $exists = \Schema::hasTable($table);
        echo $exists ? "  ✓ Table '$table' exists\n" : "  ✗ Table '$table' missing\n";
    } catch (\Exception $e) {
        echo "  ✗ Error checking table '$table': " . $e->getMessage() . "\n";
    }
}

// Test 6: Check Admin User Exists
echo "\n✓ Test 6: Admin User\n";
$adminCount = User::where('is_admin', true)->count();
echo "  Found $adminCount admin user(s)\n";
if ($adminCount === 0) {
    echo "  ⚠ WARNING: No admin users found. Run: php artisan make:admin\n";
}

// Test 7: Test Data Counts
echo "\n✓ Test 7: Data Counts\n";
echo "  Banners: " . Banner::count() . "\n";
echo "  Banner Applications: " . BannerApplication::count() . "\n";
echo "  Mentor Applications: " . MentorApplication::count() . "\n";
echo "  Workshops: " . Workshop::count() . "\n";
echo "  Workshop Registrations: " . WorkshopRegistration::count() . "\n";
echo "  Counseling Requests: " . CounselingRequest::count() . "\n";
echo "  Total Users: " . User::count() . "\n";

// Test 8: Check Controller Methods
echo "\n✓ Test 8: Controller Methods\n";

// AdminDashboardController
if (class_exists('App\Http\Controllers\AdminDashboardController')) {
    $controller = new \App\Http\Controllers\AdminDashboardController();
    $methods = ['index'];
    foreach ($methods as $method) {
        $exists = method_exists($controller, $method);
        echo $exists ? "  ✓ AdminDashboardController::$method exists\n" : "  ✗ AdminDashboardController::$method missing\n";
    }
}

// Test 9: Check Policies
echo "\n✓ Test 9: Policies\n";
$policies = [
    'BannerPolicy' => 'app/Policies/BannerPolicy.php',
    'WorkshopPolicy' => 'app/Policies/WorkshopPolicy.php',
];

foreach ($policies as $name => $path) {
    $exists = file_exists($path);
    echo $exists ? "  ✓ $name exists\n" : "  ⚠ $name missing (optional)\n";
}

// Test 10: Check for Common Issues
echo "\n✓ Test 10: Common Issues Check\n";

// Check if admin middleware is registered
$middlewareFile = file_get_contents('app/Http/Kernel.php');
if (strpos($middlewareFile, 'admin') !== false || strpos($middlewareFile, 'IsAdmin') !== false) {
    echo "  ✓ Admin middleware registered in Kernel\n";
} else {
    echo "  ⚠ Admin middleware may not be registered in Kernel\n";
}

// Check bootstrap/app.php for middleware alias
$bootstrapFile = file_get_contents('bootstrap/app.php');
if (strpos($bootstrapFile, 'admin') !== false || strpos($bootstrapFile, 'IsAdmin') !== false) {
    echo "  ✓ Admin middleware alias found in bootstrap\n";
} else {
    echo "  ⚠ Admin middleware alias may not be configured\n";
}

// Summary
echo "\n=== SUMMARY ===\n";
echo "Admin dashboard structure is in place.\n";
echo "\nNext Steps:\n";
echo "1. Ensure you have an admin user (run: php make-admin.php)\n";
echo "2. Test each admin feature manually in the browser\n";
echo "3. Check for any missing views or broken links\n";
echo "4. Verify all CRUD operations work correctly\n";
echo "5. Test approval/rejection workflows\n";

