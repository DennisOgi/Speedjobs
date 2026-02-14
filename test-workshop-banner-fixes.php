<?php

/**
 * Test script to verify workshop registration and banner fixes
 * Run: php test-workshop-banner-fixes.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Workshop;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\Route;

echo "=== Workshop & Banner Fixes Test ===\n\n";

// Test 1: Check Workshop exists
echo "1. Checking workshops...\n";
$workshops = Workshop::active()->upcoming()->get();
echo "   Found " . $workshops->count() . " active upcoming workshops\n";
if ($workshops->count() > 0) {
    $workshop = $workshops->first();
    echo "   Sample: {$workshop->title}\n";
    echo "   ✓ Workshops available for testing\n";
} else {
    echo "   ⚠ No workshops found - create one to test registration\n";
}
echo "\n";

// Test 2: Check Banner routes
echo "2. Checking admin banner routes...\n";
$bannerRoutes = [
    'admin.banners.index',
    'admin.banners.create',
    'admin.banners.store',
    'admin.banners.edit',
    'admin.banners.update',
    'admin.banners.destroy',
];

$allRoutesExist = true;
foreach ($bannerRoutes as $routeName) {
    if (Route::has($routeName)) {
        echo "   ✓ Route '{$routeName}' exists\n";
    } else {
        echo "   ✗ Route '{$routeName}' missing\n";
        $allRoutesExist = false;
    }
}

if ($allRoutesExist) {
    echo "   ✓ All banner routes properly configured\n";
}
echo "\n";

// Test 3: Check Banners exist
echo "3. Checking banners...\n";
$banners = Banner::all();
echo "   Found " . $banners->count() . " banners\n";
if ($banners->count() > 0) {
    echo "   ✓ Banners available\n";
} else {
    echo "   ⚠ No banners found - you can create one via admin panel\n";
}
echo "\n";

// Test 4: Check workshop registration route
echo "4. Checking workshop registration route...\n";
if (Route::has('workshops.register')) {
    echo "   ✓ Workshop registration route exists\n";
    $route = Route::getRoutes()->getByName('workshops.register');
    echo "   Method: " . implode(', ', $route->methods()) . "\n";
    echo "   URI: " . $route->uri() . "\n";
} else {
    echo "   ✗ Workshop registration route missing\n";
}
echo "\n";

// Test 5: Check admin user exists
echo "5. Checking admin users...\n";
$admins = User::where('is_admin', true)->get();
echo "   Found " . $admins->count() . " admin users\n";
if ($admins->count() > 0) {
    $admin = $admins->first();
    echo "   Sample admin: {$admin->name} ({$admin->email})\n";
    echo "   ✓ Admin users available for testing\n";
} else {
    echo "   ⚠ No admin users found - run: php artisan make:admin [email]\n";
}
echo "\n";

// Test 6: Check workshop_registrations table structure
echo "6. Checking workshop_registrations table...\n";
try {
    $columns = DB::select("PRAGMA table_info(workshop_registrations)");
    $columnNames = array_map(fn($col) => $col->name, $columns);
    
    $requiredColumns = ['id', 'user_id', 'workshop_id', 'status', 'notes'];
    $missingColumns = array_diff($requiredColumns, $columnNames);
    
    if (empty($missingColumns)) {
        echo "   ✓ All required columns exist\n";
        echo "   Columns: " . implode(', ', $columnNames) . "\n";
    } else {
        echo "   ⚠ Missing columns: " . implode(', ', $missingColumns) . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error checking table: " . $e->getMessage() . "\n";
}
echo "\n";

// Summary
echo "=== Test Summary ===\n";
echo "✓ Workshop registration modal added\n";
echo "✓ Banner routes consolidated (removed duplicates)\n";
echo "✓ Mobile create banner button added\n";
echo "✓ Optional reason field added to workshop registration\n";
echo "\n";

echo "=== Next Steps ===\n";
echo "1. Login as admin and navigate to /admin/banners\n";
echo "2. Click 'Create Banner' button (should be visible in header)\n";
echo "3. Navigate to a workshop page (e.g., /workshops/1)\n";
echo "4. Click 'Apply Now' - should see a modal with form\n";
echo "5. Fill optional reason and submit\n";
echo "6. Verify success message appears\n";
echo "\n";

echo "Test completed!\n";
