# 🚨 Create Admin Account NOW - Railway Shell

## The account doesn't exist yet. Create it manually:

### Step 1: Open Railway Shell
1. Go to https://railway.app
2. Click your project
3. Click your service
4. Click "..." menu (top right)
5. Select "Shell"

### Step 2: Run ONE of These Commands

**Option A: Use the PHP script (if file exists)**
```bash
php create-railway-admin.php
```

**Option B: Use Artisan Tinker (Most Reliable)**
```bash
php artisan tinker --execute="\\App\\Models\\User::updateOrCreate(['email' => 'test@speedjobs.com'], ['name' => 'Test Admin', 'password' => \\Illuminate\\Support\\Facades\\Hash::make('password'), 'email_verified_at' => now(), 'is_admin' => true, 'is_paid' => true, 'role' => 'jobseeker']); echo 'Admin created successfully!';"
```

**Option C: Interactive Tinker**
```bash
php artisan tinker
```

Then paste this and press Enter:
```php
$user = \App\Models\User::updateOrCreate(
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
echo "✅ Admin created: " . $user->email . "\n";
echo "Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
echo "Paid: " . ($user->is_paid ? 'Yes' : 'No') . "\n";
```

Press Ctrl+D to exit tinker.

### Step 3: Verify Account Was Created
```bash
php artisan tinker --execute="\\App\\Models\\User::where('email', 'test@speedjobs.com')->first();"
```

You should see the user details.

### Step 4: Login
Go to your Railway URL and login:
- Email: `test@speedjobs.com`
- Password: `password`

## Why Didn't the Seeder Work?

The seeder in the start command might have failed silently. Check Railway logs for errors.

## Make It Work on Future Deployments

The seeder should work on future deployments, but if it keeps failing, you can:

1. **Check Railway Logs** for seeder errors
2. **Use Railway's Deploy Command** feature instead of nixpacks start command
3. **Create a post-deploy hook** in Railway settings

## Quick Verification Commands

```bash
# Check if user exists
php artisan tinker --execute="\\App\\Models\\User::where('email', 'test@speedjobs.com')->exists() ? 'User exists' : 'User NOT found';"

# Count total users
php artisan tinker --execute="echo \\App\\Models\\User::count() . ' users in database';"

# List all users
php artisan tinker --execute="\\App\\Models\\User::all(['id', 'name', 'email', 'is_admin', 'is_paid'])->toArray();"
```

## DO THIS NOW

Open Railway Shell and run Option B (the long tinker command). It will create the account immediately and you can login right away!
