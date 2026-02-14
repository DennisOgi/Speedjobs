<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;

echo "=== Implementation Verification ===\n\n";

// 1. Check banner image
echo "1. Checking banner image...\n";
$banner = App\Models\Banner::where('title', 'test')->first();
if ($banner && $banner->image) {
    echo "   ✓ Banner has image: {$banner->image}\n";
    $exists = Storage::disk('public')->exists($banner->image);
    echo "   " . ($exists ? "✓" : "✗") . " Image file exists\n";
} else {
    echo "   ✗ No test banner or image found\n";
}
echo "\n";

// 2. Check workshop routes removed
echo "2. Checking workshop routes removed...\n";
$workshopRoutes = ['workshops.index', 'workshops.show', 'workshops.register'];
$allRemoved = true;
foreach ($workshopRoutes as $routeName) {
    $exists = Route::has($routeName);
    echo "   " . ($exists ? "✗" : "✓") . " Route '{$routeName}' " . ($exists ? "still exists" : "removed") . "\n";
    if ($exists) $allRemoved = false;
}
echo "\n";

// 3. Check banner application routes exist
echo "3. Checking banner application routes...\n";
$bannerRoutes = ['banners.apply', 'banner-applications.index'];
$allExist = true;
foreach ($bannerRoutes as $routeName) {
    $exists = Route::has($routeName);
    echo "   " . ($exists ? "✓" : "✗") . " Route '{$routeName}' " . ($exists ? "exists" : "missing") . "\n";
    if (!$exists) $allExist = false;
}
echo "\n";

// 4. Check banner applications
echo "4. Checking banner applications...\n";
$applications = App\Models\BannerApplication::count();
echo "   Total applications: {$applications}\n";
if ($applications > 0) {
    $pending = App\Models\BannerApplication::where('status', 'pending')->count();
    $approved = App\Models\BannerApplication::where('status', 'approved')->count();
    $rejected = App\Models\BannerApplication::where('status', 'rejected')->count();
    echo "   - Pending: {$pending}\n";
    echo "   - Approved: {$approved}\n";
    echo "   - Rejected: {$rejected}\n";
}
echo "\n";

// 5. Check active banners
echo "5. Checking active banners...\n";
$activeBanners = App\Models\Banner::active()->get();
echo "   Active banners: {$activeBanners->count()}\n";
foreach ($activeBanners as $banner) {
    echo "   - {$banner->title} ({$banner->type})\n";
}
echo "\n";

// Summary
echo "=== Summary ===\n";
echo ($banner && $banner->image && Storage::disk('public')->exists($banner->image) ? "✓" : "✗") . " Banner image working\n";
echo ($allRemoved ? "✓" : "✗") . " Workshop routes removed\n";
echo ($allExist ? "✓" : "✗") . " Banner application routes exist\n";
echo "✓ Active banners: {$activeBanners->count()}\n";
echo "✓ Total applications: {$applications}\n";
echo "\n";

echo "Implementation verification complete!\n";
