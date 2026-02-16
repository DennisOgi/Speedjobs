# 🔍 Final Railway AI Debug Steps

## I've added a debug route to diagnose the issue

### Step 1: Push the Debug Route

```bash
git add routes/web.php FINAL_RAILWAY_DEBUG.md
git commit -m "Add Gemini API debug route"
git push
```

### Step 2: Wait for Railway to Deploy (2-3 minutes)

### Step 3: Visit the Debug URL

After logging in to your Railway site, visit:
```
https://your-railway-url.railway.app/debug-gemini-config
```

### Step 4: Check the Response

You should see JSON like this:

**✅ GOOD (API key is loaded):**
```json
{
  "config_key_exists": true,
  "config_key_length": 39,
  "config_key_prefix": "AIzaSyC...",
  "env_key_exists": true,
  "env_key_length": 39,
  "env_key_prefix": "AIzaSyC...",
  "config_model": "gemini-1.5-flash",
  "all_env_keys": ["GEMINI_API_KEY"]
}
```

**❌ BAD (API key NOT loaded):**
```json
{
  "config_key_exists": false,
  "config_key_length": 0,
  "config_key_prefix": "NULL",
  "env_key_exists": false,
  "env_key_length": 0,
  "env_key_prefix": "NULL",
  "config_model": "gemini-1.5-flash",
  "all_env_keys": []
}
```

### Step 5: Based on the Response

#### If `config_key_exists` is `true`:
The API key IS loaded. The problem is something else:
1. **Check Railway Logs** for Gemini API errors
2. **Verify API Key is Valid** at https://makersuite.google.com/app/apikey
3. **Check API Quota** - you might have hit the limit
4. **Test API directly** - the key might be restricted

#### If `config_key_exists` is `false`:
The API key is NOT being loaded. Solutions:

**Solution 1: Double-check Railway Variables**
1. Railway Dashboard → Service → Variables
2. Verify variable name is EXACTLY: `GEMINI_API_KEY` (case-sensitive)
3. Check for typos
4. Verify no extra spaces in the value
5. Make sure it's added to the correct service (Laravel app, not database)

**Solution 2: Force Redeploy**
1. Railway Dashboard → Service → Deployments
2. Click "..." on latest deployment
3. Click "Redeploy"

**Solution 3: Use .env.production (Last Resort)**
If Railway isn't loading environment variables, add them to a file:

Create `.env.production`:
```env
GEMINI_API_KEY=your-actual-key-here
```

Update `nixpacks.toml`:
```toml
[phases.build]
cmds = [
  "npm install",
  "npm run build",
  "cp .env.production .env"
]
```

**⚠️ Warning**: This is less secure but will work if Railway variables aren't loading.

### Step 6: Common Issues

#### Issue: API Key Has Spaces
```
❌ " AIzaSyC..." (space before)
❌ "AIzaSyC... " (space after)  
✅ "AIzaSyC..." (no spaces)
```

#### Issue: Wrong Variable Name
Railway variables are case-sensitive:
```
❌ gemini_api_key
❌ GEMINI_KEY
❌ GEMINI_API
✅ GEMINI_API_KEY
```

#### Issue: Added to Wrong Service
If you have multiple services in Railway (e.g., web + database), make sure you added the variable to the web service, not the database.

#### Issue: Config Cache
Even though we added `config:clear`, try manually clearing:
1. Railway Dashboard → Service → "..." → "Restart"

### Step 7: Test Locally First

To rule out Railway-specific issues, test locally:

1. Add to your local `.env`:
```env
GEMINI_API_KEY=your-key-here
```

2. Clear config:
```bash
php artisan config:clear
php artisan config:cache
```

3. Test AI features locally

4. If they work locally but not on Railway, it's definitely a Railway environment variable issue.

### Step 8: Check Railway Logs

Look for these specific errors:

```
# API key not found
"GEMINI_API_KEY not set"
"API key is required"

# API key invalid
"Invalid API key"
"API key not valid"

# API quota exceeded
"Quota exceeded"
"Resource exhausted"

# Network issues
"cURL error"
"Connection timeout"
"Failed to connect"
```

### Step 9: Verify API Key Works

Test your API key directly with curl:

```bash
curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=YOUR_API_KEY" \
  -H 'Content-Type: application/json' \
  -d '{"contents":[{"parts":[{"text":"Say hello"}]}]}'
```

If this fails, your API key is invalid or restricted.

### Step 10: Last Resort Solutions

If nothing works:

**Option A: Generate New API Key**
1. Go to https://makersuite.google.com/app/apikey
2. Delete old key
3. Create new key
4. Update Railway Variables
5. Redeploy

**Option B: Use Different AI Service**
If Gemini keeps failing, you could switch to OpenAI or Claude (requires code changes).

**Option C: Disable AI Features Temporarily**
Add fallback responses when AI fails (already implemented in most controllers).

## Summary

1. ✅ Push the debug route
2. ✅ Visit `/debug-gemini-config` on Railway
3. ✅ Check if `config_key_exists` is true or false
4. ✅ Follow the appropriate solution based on the result
5. ✅ Report back what you see in the JSON response

The debug route will tell us exactly what's wrong! 🔍
