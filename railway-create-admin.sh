#!/bin/bash

# Railway Admin Account Creator
# Run this in Railway shell: bash railway-create-admin.sh

echo "🚀 Creating Railway Admin Account..."
echo ""

php artisan tinker --execute="
\$user = \App\Models\User::updateOrCreate(
    ['email' => 'test@speedjobs.com'],
    [
        'name' => 'Test Admin',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'email_verified_at' => now(),
        'is_admin' => true,
        'is_paid' => true,
        'role' => 'jobseeker',
    ]
);
echo '✅ Admin account created/updated\n';
echo '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n';
echo '📧 Email:    test@speedjobs.com\n';
echo '🔑 Password: password\n';
echo '👑 Admin:    Yes\n';
echo '💳 Paid:     Yes\n';
echo '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n';
"

echo ""
echo "✨ You can now login at your Railway URL!"
echo ""
