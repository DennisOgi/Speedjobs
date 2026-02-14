<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        $user = User::where('email', 'test@speedjobs.com')->first();

        if ($user) {
            // Update existing user
            $user->update([
                'name' => 'Test User',
                'is_admin' => true,
                'is_paid' => true,
                'role' => 'jobseeker',
                'password' => Hash::make('password'), // Default password
            ]);
            
            echo "✓ Updated existing test admin account\n";
        } else {
            // Create new user
            User::create([
                'name' => 'Test User',
                'email' => 'test@speedjobs.com',
                'password' => Hash::make('password'), // Default password
                'email_verified_at' => now(),
                'is_admin' => true,
                'is_paid' => true,
                'role' => 'jobseeker',
            ]);
            
            echo "✓ Created new test admin account\n";
        }

        echo "\nTest Admin Credentials:\n";
        echo "Email: test@speedjobs.com\n";
        echo "Password: password\n";
        echo "Is Admin: Yes\n";
        echo "Is Paid: Yes\n";
    }
}
