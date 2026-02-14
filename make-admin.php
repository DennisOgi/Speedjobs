<?php

/**
 * Quick script to make test user an admin
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║              MAKE USER ADMIN                                   ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$email = 'test@speedjobs.com';

echo "Looking for user: {$email}...\n";

$user = User::where('email', $email)->first();

if (!$user) {
    echo "✗ User not found!\n";
    echo "\nAvailable users:\n";
    $users = User::take(5)->get();
    foreach ($users as $u) {
        echo "  - {$u->email}\n";
    }
    exit(1);
}

echo "✓ User found: {$user->name}\n\n";

if ($user->is_admin) {
    echo "✓ User is already an admin!\n";
} else {
    echo "Granting admin access...\n";
    $user->is_admin = true;
    $user->save();
    echo "✓ Admin access granted!\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "ADMIN ACCESS DETAILS\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Email: {$user->email}\n";
echo "Password: password\n";
echo "Admin Status: " . ($user->is_admin ? "✓ YES" : "✗ NO") . "\n";
echo "Paid Status: " . ($user->is_paid ? "✓ YES" : "✗ NO") . "\n";

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "HOW TO ACCESS ADMIN DASHBOARD\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "1. Open your browser\n";
echo "2. Go to: http://127.0.0.1:8000/login\n";
echo "3. Login with the credentials above\n";
echo "4. Navigate to: http://127.0.0.1:8000/admin/dashboard\n";

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "ADMIN FEATURES AVAILABLE\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "✓ Dashboard - View statistics and recent activity\n";
echo "✓ Banners - Manage banner advertisements\n";
echo "✓ Users - Manage user accounts and permissions\n";
echo "✓ Counseling - Handle counseling requests\n";
echo "✓ Workshops - Create and manage workshops\n";
echo "✓ Resources - Upload and manage resources\n";
echo "✓ Applications - Review programme applications\n";

echo "\n";
echo "✓ READY TO GO!\n";
echo "\n";
