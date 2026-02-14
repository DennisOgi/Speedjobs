<?php

/**
 * Helper script to cancel workshop registrations for testing
 * Run: php cancel-workshop-registration.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\WorkshopRegistration;
use App\Models\User;

echo "=== Cancel Workshop Registration ===\n\n";

// Get all registrations
$registrations = WorkshopRegistration::with(['user', 'workshop'])->get();

if ($registrations->isEmpty()) {
    echo "No workshop registrations found.\n";
    exit(0);
}

echo "Found " . $registrations->count() . " registration(s):\n\n";

foreach ($registrations as $index => $registration) {
    echo ($index + 1) . ". User: {$registration->user->name} ({$registration->user->email})\n";
    echo "   Workshop: {$registration->workshop->title}\n";
    echo "   Status: {$registration->status}\n";
    echo "   Registered: {$registration->created_at->format('M d, Y')}\n";
    if ($registration->notes) {
        echo "   Reason: " . Str::limit($registration->notes, 50) . "\n";
    }
    echo "\n";
}

echo "Enter the number of the registration to cancel (or 'all' to cancel all, or 'q' to quit): ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));

if (strtolower($line) === 'q') {
    echo "Cancelled.\n";
    exit(0);
}

if (strtolower($line) === 'all') {
    foreach ($registrations as $registration) {
        $registration->delete();
    }
    echo "\n✓ All registrations deleted successfully!\n";
    echo "You can now test the workshop registration modal.\n";
    exit(0);
}

$index = (int)$line - 1;

if (!isset($registrations[$index])) {
    echo "Invalid selection.\n";
    exit(1);
}

$registration = $registrations[$index];
$registration->delete();

echo "\n✓ Registration deleted successfully!\n";
echo "User {$registration->user->name} can now register for {$registration->workshop->title} again.\n";
echo "Navigate to the workshop page and click 'Apply Now' to test the modal.\n";
