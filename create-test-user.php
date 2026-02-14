<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Creating test user...\n\n";

// Check if user already exists
$existingUser = User::where('email', 'test@speedjobs.com')->first();

if ($existingUser) {
    echo "✅ User already exists!\n";
    echo "   Email: test@speedjobs.com\n";
    echo "   Password: password\n\n";
    
    // Make sure they're premium
    if (!$existingUser->is_paid) {
        $existingUser->update(['is_paid' => true]);
        echo "✅ User upgraded to premium!\n\n";
    } else {
        echo "✅ User is already premium!\n\n";
    }
    
    exit(0);
}

// Create new user
$user = User::create([
    'name' => 'Test User',
    'email' => 'test@speedjobs.com',
    'password' => Hash::make('password'),
    'role' => 'jobseeker',
    'is_paid' => true,
    'university' => 'University of Lagos',
    'field_of_study' => 'Computer Science',
    'graduation_year' => 2024,
    'skills' => 'PHP, Laravel, JavaScript, React',
    'experience_level' => 'entry',
    'location' => 'Lagos, Nigeria',
    'email_verified_at' => now(),
]);

echo "✅ Test user created successfully!\n\n";
echo "Login Credentials:\n";
echo "==================\n";
echo "Email:    test@speedjobs.com\n";
echo "Password: password\n";
echo "Status:   Premium (is_paid = 1)\n\n";
echo "You can now:\n";
echo "1. Visit: http://127.0.0.1:8000\n";
echo "2. Login with the credentials above\n";
echo "3. Go to AI Career Counselor\n";
echo "4. Start chatting!\n\n";
