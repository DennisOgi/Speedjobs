# 🔧 Railway Admin Account Fix

## Problem
The test admin account (`test@speedjobs.com`) is not working after deployment.

## Quick Fix - Run This Command on Railway

### Option 1: Use Railway Shell (Easiest)

1. Go to your Railway project dashboard
2. Click on your service
3. Click the "..." menu (top right)
4. Select "Shell" or "Terminal"
5. Run this command:

```bash
php create-railway-admin.php
```

This will create/update the admin account immediately.

### Option 2: Use Railway CLI

If you have Railway CLI installed locally:

```bash
railway run php create-railway-admin.php
```

### Option 3: Run Seeder Manually

```bash
railway run php artisan db:seed --class=TestAdminSeeder --force
```

### Option 4: Use Artisan Command

```bash
railway run php artisan make:admin test@speedjobs.com
```

## Why Didn't It Work Automatically?

The `nixpacks.toml` start command might not have executed the seeder. Let me check the Railway logs to see what happened.

## Alternative: Update nixpacks.toml

If the seeder keeps failing, we can separate the commands:

**Current `nixpacks.toml`:**
```toml
[start]
cmd = "php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT"
```

**Try this instead:**
```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer", "nodejs_20"]

[phases.install]
cmds = [
  "composer install --no-dev --optimize-autoloader --no-interaction"
]

[phases.build]
cmds = [
  "npm install",
  "npm run build"
]

[phases.deploy]
cmds = [
  "php artisan migrate --force",
  "php artisan db:seed --class=TestAdminSeeder --force",
  "php artisan storage:link"
]

[start]
cmd = "php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT"
```

## Permanent Solution: Use Railway's Deploy Hooks

In Railway dashboard:

1. Go to your service → Settings
2. Scroll to "Deploy"
3. Add "Deploy Command":
   ```bash
   php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link
   ```

This runs BEFORE the start command, ensuring the admin is created before the app starts.

## Verify Admin Account Exists

Run this in Railway shell:

```bash
php artisan tinker
```

Then type:
```php
User::where('email', 'test@speedjobs.com')->first()
```

You should see the user details. If null, the account doesn't exist.

## Create Admin Account Manually (Last Resort)

If all else fails, run this in Railway shell:

```bash
php artisan tinker
```

Then paste this:
```php
$user = \App\Models\User::updateOrCreate(
    ['email' => 'test@speedjobs.com'],
    [
        'name' => 'Test Admin',
        'password' => \Hash::make('password'),
        'email_verified_at' => now(),
        'is_admin' => true,
        'is_paid' => true,
        'role' => 'jobseeker',
    ]
);
echo "Admin created: " . $user->email;
```

Press Ctrl+D to exit tinker.

## Test Login

After creating the account, try logging in:
- URL: `https://your-app.railway.app/login`
- Email: `test@speedjobs.com`
- Password: `password`

## Next Steps

1. ✅ Run `php create-railway-admin.php` in Railway shell NOW
2. ✅ Test login
3. ✅ Update nixpacks.toml if needed
4. ✅ Push changes
5. ✅ Verify admin works after next deployment

## Files to Push

I've created:
- ✅ `create-railway-admin.php` - Standalone script to create admin
- ✅ This guide

Push these files, then run the script on Railway!
