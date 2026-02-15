# 🚀 Create Admin Account - Railway CLI Method

## Railway Shell Access Has Changed

Railway's web interface may not have a direct "Shell" button anymore. Use Railway CLI instead.

## Solution 1: Use Railway CLI (Recommended)

### Step 1: Install Railway CLI

**Windows (PowerShell):**
```powershell
iwr https://railway.app/install.ps1 | iex
```

**Mac/Linux:**
```bash
curl -fsSL https://railway.app/install.sh | sh
```

Or use npm:
```bash
npm install -g @railway/cli
```

### Step 2: Login to Railway
```bash
railway login
```

This will open your browser to authenticate.

### Step 3: Link to Your Project
```bash
cd C:\Users\HP\Desktop\spa\speedjobs
railway link
```

Select your project from the list.

### Step 4: Create Admin Account
```bash
railway run php artisan tinker --execute="\App\Models\User::updateOrCreate(['email' => 'test@speedjobs.com'], ['name' => 'Test Admin', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'email_verified_at' => now(), 'is_admin' => true, 'is_paid' => true, 'role' => 'jobseeker']); echo 'Admin created!';"
```

### Step 5: Verify
```bash
railway run php artisan tinker --execute="\App\Models\User::where('email', 'test@speedjobs.com')->first();"
```

### Step 6: Login
Go to your Railway URL and login with:
- Email: `test@speedjobs.com`
- Password: `password`

---

## Solution 2: Use a One-Time Migration

Create a migration that seeds the admin account:

### Step 1: Create Migration File Locally

Create `database/migrations/2026_02_15_000001_seed_test_admin.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
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

    public function down(): void
    {
        User::where('email', 'test@speedjobs.com')->delete();
    }
};
```

### Step 2: Push to Railway
```bash
git add database/migrations/2026_02_15_000001_seed_test_admin.php
git commit -m "Add migration to seed test admin"
git push
```

Railway will automatically run the migration and create the admin account!

---

## Solution 3: Use Railway's Deployments Tab

1. Go to Railway Dashboard
2. Click your service
3. Click "Deployments" tab
4. Click on the latest deployment
5. Look for "Logs" - check if the seeder ran
6. If there's an error, you'll see it there

---

## Solution 4: Temporary Public Route (Quick Hack)

Add this route temporarily to create the admin:

### Step 1: Add to `routes/web.php`

```php
// TEMPORARY - Remove after creating admin
Route::get('/create-admin-temp', function () {
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
    
    return response()->json([
        'success' => true,
        'message' => 'Admin account created',
        'email' => $user->email,
        'is_admin' => $user->is_admin,
        'is_paid' => $user->is_paid,
    ]);
});
```

### Step 2: Push to Railway
```bash
git add routes/web.php
git commit -m "Add temp admin creation route"
git push
```

### Step 3: Visit the URL
Go to: `https://your-railway-url.railway.app/create-admin-temp`

You'll see a JSON response confirming the admin was created.

### Step 4: Remove the Route
```bash
git checkout routes/web.php
git commit -m "Remove temp admin route"
git push
```

---

## Recommended: Use Solution 2 (Migration)

This is the cleanest approach - the migration will run automatically on Railway and create the admin account. I'll create this file for you now.
