# 🤖 Fix AI Features on Railway

## Problem
AI features (Career Counselor, Resume Analysis, Interview Coach, etc.) are not working because the Gemini API key is missing.

## Solution: Add GEMINI_API_KEY to Railway

### Step 1: Get Your Gemini API Key

If you don't have one:
1. Go to https://makersuite.google.com/app/apikey
2. Click "Create API Key"
3. Copy the key (starts with `AIza...`)

### Step 2: Add to Railway Environment Variables

1. Go to Railway Dashboard: https://railway.app
2. Click your project
3. Click your service (the one running your Laravel app)
4. Click the **"Variables"** tab
5. Click **"+ New Variable"**
6. Add:
   - **Variable**: `GEMINI_API_KEY`
   - **Value**: Your API key (e.g., `AIzaSyC...`)
7. Click **"Add"**

### Step 3: Redeploy (Automatic)

Railway will automatically redeploy your app with the new environment variable.

Wait 2-3 minutes for the deployment to complete.

### Step 4: Test AI Features

Try these features:
- ✅ AI Career Counselor (`/ai-counselor`)
- ✅ Career Assessment (`/assessments`)
- ✅ Resume Analysis (`/resume-analysis`)
- ✅ Interview Coach (`/interview-coach`)
- ✅ Career Planning (`/career-planning`)

## Verify Environment Variable is Set

If you have Railway CLI installed:

```bash
railway variables
```

You should see `GEMINI_API_KEY` in the list.

## Check Railway Logs

If AI features still don't work:

1. Go to Railway Dashboard
2. Click your service
3. Click "Deployments" tab
4. Click latest deployment
5. Check logs for errors like:
   - `GEMINI_API_KEY not set`
   - `API key invalid`
   - `Gemini API error`

## Common Issues

### Issue 1: API Key Invalid
**Error**: "Invalid API key"
**Solution**: 
- Verify the key is correct
- Make sure there are no extra spaces
- Generate a new key if needed

### Issue 2: API Quota Exceeded
**Error**: "Quota exceeded"
**Solution**:
- Check your Google Cloud Console quota
- Wait for quota to reset (usually daily)
- Upgrade to paid tier if needed

### Issue 3: API Key Not Loading
**Error**: Features timeout or show generic errors
**Solution**:
- Verify variable name is exactly `GEMINI_API_KEY` (case-sensitive)
- Redeploy manually: Railway Dashboard → Service → "..." → "Redeploy"
- Clear config cache: Add this to nixpacks.toml start command

## Required Environment Variables for Railway

Make sure these are all set in Railway Variables:

```env
# App Configuration
APP_NAME="SpeedJobs Africa"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway provides these automatically)
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

# AI Features (YOU NEED TO ADD THIS)
GEMINI_API_KEY=your-gemini-api-key-here

# File Storage
FILESYSTEM_DISK=public
```

## Test AI Features Locally First

Before deploying, test locally:

1. Add `GEMINI_API_KEY` to your `.env` file
2. Run: `php artisan config:clear`
3. Test AI features locally
4. If they work, the issue is Railway environment variables

## Alternative: Use .env.production

If Railway doesn't pick up environment variables:

1. Create `.env.production` in your project root
2. Add:
```env
GEMINI_API_KEY=your-key-here
```
3. Update `nixpacks.toml` to copy this file
4. Push to Railway

**Note**: This is less secure than using Railway's environment variables.

## Summary

1. ✅ Get Gemini API key from https://makersuite.google.com/app/apikey
2. ✅ Add `GEMINI_API_KEY` to Railway Variables tab
3. ✅ Wait for automatic redeploy (2-3 minutes)
4. ✅ Test AI features

That's it! AI features should work after adding the API key. 🚀
