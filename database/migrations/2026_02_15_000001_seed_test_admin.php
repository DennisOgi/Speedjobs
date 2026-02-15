<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration creates/updates the test admin account for Railway deployment.
     */
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'test@speedjobs.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
                'is_paid' => true,
                'role' => 'jobseeker',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'test@speedjobs.com')->delete();
    }
};
