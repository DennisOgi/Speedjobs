# 🔧 Railway AI Features Troubleshooting

## Problem: None of the AI features are working

Even though you've added GEMINI_API_KEY to Railway Variables, the AI features still fail.

## Root Causes & Solutions

### Issue 1: Config Cache Not Cleared

Railway may have cached the old config without the API key.

**Solution**: Update nixpacks.toml to clear config cache on every deployment.

Add this to your `nixpacks.toml`:

```toml
[start]
cmd = "php artisan config:clear && php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT"
```

Then push:
```bash
git add nixpacks.toml
git commit -m "Clear config cache on Railway startup"
git push
```

### Issue 2: Environment Variable Not Loading

The GEMINI_API_KEY might not be accessible to the app.

**Verify**:
1. Railway Dashboard → Service → Variables
2. Confirm `GEMINI_API_KEY` is listed
3. Check there are no typos in the variable name (case-sensitive!)
4. Verify the value doesn't have extra spaces

**Test**: Add a temporary debug route to check if the key is loaded.

### Issue 3: App Didn't Redeploy

After adding environment variables, Railway should auto-redeploy, but sometimes it doesn't.

**Solution**: Force a redeploy
1. Railway Dashboard → Service → Deployments
2. Click "..." on latest deployment
3. Click "Redeploy"

OR push any change:
```bash
git commit --allow-empty -m "Force Railway redeploy"
git push
```

### Issue 4: Invalid API Key

The API key might be invalid or restricted.

**Verify**:
1. Go to https://makersuite.google.com/app/apikey
2. Check if your key is active
3. Try generating a new key
4. Update Railway Variables with new key

### Issue 5: Gemini API Quota Exceeded

Your API might have hit its quota limit.

**Check**:
1. Go to Google Cloud Console
2. Check Gemini API quota usage
3. Wait for quota reset (usually daily)
4. Or upgrade to paid tier

## Debugging Steps

### Step 1: Check Railway Logs

1. Railway Dashboard → Service → Deployments
2. Click latest deployment
3. Look for errors containing:
   - "GEMINI_API_KEY"
   - "API key"
   - "Gemini"
   - "cURL error"
   - "Connection timeout"

### Step 2: Add Debug Logging

Temporarily add this route to `routes/web.php`:

```php
// TEMPORARY DEBUG - Remove after testing
Route::get('/debug-gemini', function () {
    return response()->json([
        'key_exists' => !empty(config('services.gemini.api_key')),
        'key_length' => strlen(config('services.gemini.api_key') ?? ''),
        'key_prefix' => substr(config('services.gemini.api_key') ?? '', 0, 10) . '...',
        'env_direct' => !empty(env('GEMINI_API_KEY')),
    ]);
})->middleware('auth');
```

Push this, then visit: `https://your-app.railway.app/debug-gemini`

You should see:
```json
{
  "key_exists": true,
  "key_length": 39,
  "key_prefix": "AIzaSyC...",
  "env_direct": true
}
```

If `key_exists` is false, the config isn't loading the key.

### Step 3: Verify Config File

Check `config/services.php` has:

```php
'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
],
```

### Step 4: Test Gemini API Directly

Add this temporary route:

```php
// TEMPORARY DEBUG
Route::get('/test-gemini-api', function () {
    $apiKey = config('services.gemini.api_key');
    
    if (empty($apiKey)) {
        return response()->json(['error' => 'API key not configured']);
    }
    
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey, [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'Say hello']
                        ]
                    ]
                ]
            ],
            'timeout' => 30,
        ]);
        
        return response()->json([
            'success' => true,
            'status' => $response->getStatusCode(),
            'response' => json_decode($response->getBody(), true),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'class' => get_class($e),
        ]);
    }
})->middleware('auth');
```

Visit: `https://your-app.railway.app/test-gemini-api`

This will tell you exactly what's wrong with the API connection.

## Quick Fix: Update nixpacks.toml

Replace your current `nixpacks.toml` with this:

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

[start]
cmd = "php artisan config:clear && php artisan config:cache && php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT"
```

Key changes:
- Added `php artisan config:clear` BEFORE config:cache
- This ensures fresh config is loaded with new environment variables

## Common Mistakes

### Mistake 1: Wrong Variable Name
- ❌ `GEMINI_KEY`
- ❌ `GEMINI_API`
- ❌ `gemini_api_key` (lowercase)
- ✅ `GEMINI_API_KEY` (exact match)

### Mistake 2: Extra Spaces
```
❌ " AIzaSyC..." (space before)
❌ "AIzaSyC... " (space after)
✅ "AIzaSyC..." (no spaces)
```

### Mistake 3: Wrong Service in Railway
Make sure you added the variable to the correct service (the Laravel app, not the database).

## Final Checklist

- [ ] GEMINI_API_KEY added to Railway Variables (exact spelling)
- [ ] No extra spaces in the API key value
- [ ] API key is valid (test at https://makersuite.google.com/app/apikey)
- [ ] Railway redeployed after adding variable
- [ ] Config cache cleared (updated nixpacks.toml)
- [ ] Checked Railway logs for errors
- [ ] Tested with debug routes

## If Still Not Working

1. **Check Railway Logs** - Look for specific error messages
2. **Generate New API Key** - Old key might be invalid
3. **Test Locally First** - Add key to local `.env` and test
4. **Contact Railway Support** - Environment variables might not be loading

## Summary

Most likely cause: **Config cache not cleared after adding environment variable**

**Quick fix**:
1. Update `nixpacks.toml` with `config:clear` command
2. Push changes
3. Wait for redeploy
4. Test AI features

The AI features should work after clearing the config cache!
