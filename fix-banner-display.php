<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Banner;

echo "=== Banner Display Fix ===\n\n";

$banners = Banner::all();
echo "Total Banners: {$banners->count()}\n\n";

foreach ($banners as $banner) {
    echo "Banner: {$banner->title}\n";
    echo "  ID: {$banner->id}\n";
    echo "  Active: " . ($banner->is_active ? 'YES' : 'NO') . "\n";
    echo "  Start Date: " . ($banner->start_date ? $banner->start_date->format('Y-m-d') : 'NULL') . "\n";
    echo "  End Date: " . ($banner->end_date ? $banner->end_date->format('Y-m-d') : 'NULL') . "\n";
    echo "  Order: {$banner->order}\n";
    
    // Check if it passes the active scope
    $passesScope = $banner->is_active &&
        (!$banner->start_date || $banner->start_date <= now()) &&
        (!$banner->end_date || $banner->end_date >= now());
    
    echo "  Passes Active Scope: " . ($passesScope ? 'YES' : 'NO') . "\n";
    
    if (!$passesScope) {
        echo "  ⚠ This banner will NOT show on homepage\n";
        if (!$banner->is_active) {
            echo "    Reason: Not marked as active\n";
        }
        if ($banner->start_date && $banner->start_date > now()) {
            echo "    Reason: Start date is in the future\n";
        }
        if ($banner->end_date && $banner->end_date < now()) {
            echo "    Reason: End date has passed\n";
        }
    }
    echo "\n";
}

echo "\n=== Active Banners (will show on homepage) ===\n";
$activeBanners = Banner::active()->get();
echo "Count: {$activeBanners->count()}\n\n";

foreach ($activeBanners as $banner) {
    echo "- {$banner->title} (Order: {$banner->order})\n";
}

if ($activeBanners->count() === 0) {
    echo "\n⚠ No active banners! To fix:\n";
    echo "1. Make sure banner is_active = 1\n";
    echo "2. Make sure start_date is NULL or in the past\n";
    echo "3. Make sure end_date is NULL or in the future\n";
}
