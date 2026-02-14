<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\WorkshopRegistration;

echo "=== Recent Workshop Registrations ===\n\n";

$registrations = WorkshopRegistration::with(['user', 'workshop'])
    ->latest()
    ->take(10)
    ->get();

if ($registrations->isEmpty()) {
    echo "No registrations found.\n";
} else {
    foreach ($registrations as $reg) {
        echo "✅ {$reg->user->name} registered for '{$reg->workshop->title}'\n";
        echo "   Status: {$reg->status}\n";
        echo "   Registered: {$reg->created_at->format('Y-m-d H:i:s')} ({$reg->created_at->diffForHumans()})\n\n";
    }
}

echo "Total registrations: " . WorkshopRegistration::count() . "\n";
