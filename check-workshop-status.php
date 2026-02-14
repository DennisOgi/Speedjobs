<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use App\Models\User;

echo "=== Workshop Registration Status ===\n\n";

$workshop = Workshop::first();
if (!$workshop) {
    echo "No workshops found\n";
    exit;
}

echo "Workshop: {$workshop->title}\n";
echo "ID: {$workshop->id}\n\n";

$registrations = WorkshopRegistration::where('workshop_id', $workshop->id)->with('user')->get();
echo "Total Registrations: {$registrations->count()}\n\n";

foreach ($registrations as $reg) {
    echo "- User: {$reg->user->email}\n";
    echo "  Status: {$reg->status}\n";
    echo "  ID: {$reg->id}\n\n";
}

// Delete all registrations
echo "Deleting all registrations...\n";
WorkshopRegistration::where('workshop_id', $workshop->id)->delete();
echo "✓ Done! You can now test the modal.\n";
