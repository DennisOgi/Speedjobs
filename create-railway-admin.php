<?php

/**
 * Railway Admin Account Creator
 * 
 * Run this directly on Railway to create/update the test admin account
 * 
 * Usage in Railway Shell:
 * php create-railway-admin.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🚀 Creating Railway Admin Account...\n\n";

try {
    // Check if user exists
    $user = User::where('email', 'test@speedjobs.com')->first();

    if ($user) {
        // Update existing user
        $user->update([
            'name' => 'Test Admin',
            'is_admin' => true,
            'is_paid' => true,
            'role' => 'jobseeker',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Updated existing admin account\n\n";
    } else {
        // Create new user
        $user = User::create([
            'name' => 'Test Admin',
            'email' => 'test@speedjobs.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
            'is_paid' => true,
            'role' => 'jobseeker',
        ]);
        
        echo "✅ Created new admin account\n\n";
    }

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📧 Email:    test@speedjobs.com\n";
    echo "🔑 Password: password\n";
    echo "👑 Admin:    Yes\n";
    echo "💳 Paid:     Yes\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    echo "✨ You can now login at your Railway URL!\n\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}
