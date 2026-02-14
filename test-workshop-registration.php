<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;

echo "=== Workshop Registration Debug ===\n\n";

// Get a test user
$user = User::where('role', 'jobseeker')->first();
if (!$user) {
    echo "❌ No jobseeker user found\n";
    exit;
}
echo "✅ User found: {$user->name} (ID: {$user->id})\n\n";

// Get an active workshop
$workshop = Workshop::where('is_active', true)
    ->where('start_date', '>', now())
    ->first();

if (!$workshop) {
    echo "❌ No active upcoming workshop found\n";
    exit;
}

echo "✅ Workshop found: {$workshop->title} (ID: {$workshop->id})\n";
echo "   Start Date: {$workshop->start_date->format('Y-m-d H:i')}\n";
echo "   Is Active: " . ($workshop->is_active ? 'Yes' : 'No') . "\n";
echo "   Is Sold Out: " . ($workshop->is_sold_out ? 'Yes' : 'No') . "\n";
echo "   Max Participants: " . ($workshop->max_participants ?? 'Unlimited') . "\n\n";

// Check if user already registered
$existingRegistration = WorkshopRegistration::where('user_id', $user->id)
    ->where('workshop_id', $workshop->id)
    ->first();

if ($existingRegistration) {
    echo "⚠️  User already registered for this workshop\n";
    echo "   Status: {$existingRegistration->status}\n";
    echo "   Registered at: {$existingRegistration->created_at->format('Y-m-d H:i')}\n\n";
    
    echo "Deleting existing registration for test...\n";
    $existingRegistration->delete();
    echo "✅ Deleted\n\n";
}

// Try to create registration
echo "Attempting to create registration...\n";
try {
    $registration = WorkshopRegistration::create([
        'user_id' => $user->id,
        'workshop_id' => $workshop->id,
        'status' => 'pending',
    ]);
    
    echo "✅ Registration created successfully!\n";
    echo "   Registration ID: {$registration->id}\n";
    echo "   Status: {$registration->status}\n";
    echo "   Created at: {$registration->created_at->format('Y-m-d H:i')}\n\n";
    
    // Verify it was saved
    $verify = WorkshopRegistration::find($registration->id);
    if ($verify) {
        echo "✅ Registration verified in database\n";
    } else {
        echo "❌ Registration not found in database after creation\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Registration failed!\n";
    echo "   Error: {$e->getMessage()}\n";
    echo "   File: {$e->getFile()}:{$e->getLine()}\n";
}

echo "\n=== Test Complete ===\n";
