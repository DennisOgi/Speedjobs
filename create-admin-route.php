<?php

/**
 * Temporary Admin Creation Route
 * 
 * Add this to routes/web.php temporarily, then visit the URL to create admin
 */

// Add this route to routes/web.php
Route::get('/setup-admin-account', function () {
    try {
        $user = \App\Models\User::where('email', 'test@speedjobs.com')->first();
        
        if ($user) {
            // Update existing user
            $user->update([
                'name' => 'Test Admin',
                'is_admin' => true,
                'is_paid' => true,
                'email_verified_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin account updated successfully!',
                'email' => 'test@speedjobs.com',
                'password' => 'password (unchanged)',
                'is_admin' => true,
                'is_paid' => true,
            ]);
        } else {
            // Create new user
            $user = \App\Models\User::create([
                'name' => 'Test Admin',
                'email' => 'test@speedjobs.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
                'is_paid' => true,
                'role' => 'jobseeker',
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin account created successfully!',
                'email' => 'test@speedjobs.com',
                'password' => 'password',
                'is_admin' => true,
                'is_paid' => true,
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});
