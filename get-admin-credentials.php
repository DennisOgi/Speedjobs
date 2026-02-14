<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Admin Account Credentials\n";
echo "=========================\n\n";

$admin = \App\Models\User::where('is_admin', true)->first();

if ($admin) {
    echo "✓ Admin account found:\n\n";
    echo "Email: {$admin->email}\n";
    echo "Name: {$admin->name}\n";
    echo "Role: {$admin->role}\n";
    echo "Is Admin: " . ($admin->is_admin ? 'Yes' : 'No') . "\n";
    echo "Is Paid: " . ($admin->is_paid ? 'Yes' : 'No') . "\n";
    echo "\n";
    echo "⚠ Password: The password is hashed in the database.\n";
    echo "If you don't know the password, you can reset it using:\n";
    echo "php make-admin.php\n";
    echo "\nOr create a new admin with:\n";
    echo "php artisan tinker\n";
    echo "\$user = User::where('email', '{$admin->email}')->first();\n";
    echo "\$user->password = Hash::make('your-new-password');\n";
    echo "\$user->save();\n";
} else {
    echo "⚠ No admin account found\n";
    echo "Create one using: php make-admin.php\n";
}
