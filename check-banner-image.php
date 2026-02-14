<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

$banner = Banner::where('title', 'test')->first();

if (!$banner) {
    echo "Banner not found\n";
    exit;
}

echo "Banner: {$banner->title}\n";
echo "Image path in DB: " . ($banner->image ?? 'NULL') . "\n";

if ($banner->image) {
    $exists = Storage::disk('public')->exists($banner->image);
    echo "File exists in storage: " . ($exists ? 'YES' : 'NO') . "\n";
    
    if ($exists) {
        $fullPath = Storage::disk('public')->path($banner->image);
        echo "Full path: {$fullPath}\n";
        echo "File size: " . filesize($fullPath) . " bytes\n";
    }
    
    echo "Expected URL: " . asset('storage/' . $banner->image) . "\n";
} else {
    echo "No image uploaded\n";
}
