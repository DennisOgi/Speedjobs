# 🚀 Railway Complete Setup Summary

## Current Status

### ✅ Completed
1. **Code Deployed** - Latest code is on Railway
2. **Database** - Migrations running automatically
3. **Test Admin Migration** - Created in `database/migrations/2026_02_15_000001_seed_test_admin.php`
4. **Nixpacks Config** - Fixed execution order
5. **Banner Image Paths** - Fixed to use `storage/` prefix

### ⚠️ Needs Action

#### 1. Test Admin Account
**Status**: Migration created but may not have run yet

**Fix**: Check Railway logs to see if migration ran. If not, you have 3 options:

**Option A: Wait for next deployment**
```bash
git add .
git commit -m "Trigger deployment"
git push
```

**Option B: Install Railway CLI and run**
```bash
# Install
npm install -g @railway/cli

# Login
railway login

# Link project
cd C:\Users\HP\Desktop\spa\speedjobs
railway link

# Create admin
railway run php artisan tinker --execute="\App\Models\User::updateOrCreate(['email' => 'test@speedjobs.com'], ['name' => 'Test Admin', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'email_verified_at' => now(), 'is_admin' => true, 'is_paid' => true, 'role' => 'jobseeker']); echo 'Done';"
```

**Option C: Add temporary route** (see RAILWAY_CLI_SOLUTION.md)

#### 2. AI Features (CRITICAL)
**Status**: Not working - GEMINI_API_KEY missing

**Fix**:
1. Go to Railway Dashboard → Your Service → **Variables** tab
2. Click **"+ New Variable"**
3. Add:
   - Name: `GEMINI_API_KEY`
   - Value: Your API key from https://makersuite.google.com/app/apikey
4. Save (Railway auto-redeploys)

**Verify**:
- Check Railway logs for "GEMINI_API_KEY" errors
- Test any AI feature after redeployment

#### 3. Banner Images
**Status**: Not persisting across deployments

**Fix - Choose ONE**:

**Option A: Railway Volume** (Quick, for testing)
1. Railway Dashboard → Service → Settings → Volumes
2. New Volume:
   - Mount Path: `/app/storage/app/public`
   - Size: 1GB
3. Redeploy

**Option B: Cloudinary** (Production-ready)
1. Sign up at cloudinary.com (free tier)
2. Install: `composer require cloudinary-labs/cloudinary-laravel`
3. Add to Railway Variables:
   ```
   FILESYSTEM_DISK=cloudinary
   CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
   ```
4. Push changes

#### 4. Resume Upload Issue
**Status**: Resume analysis failing

**Possible Causes**:
1. GEMINI_API_KEY not set (most likely)
2. File storage not persistent (Railway ephemeral filesystem)
3. PDF parsing library missing

**Fix**:
1. Add GEMINI_API_KEY (see #2 above)
2. Set up persistent storage (see #3 above)
3. Verify Railway has required PHP extensions:
   - Check Railway logs for "extension not found" errors

## Quick Checklist

### Immediate Actions (Do These Now)

- [ ] **Add GEMINI_API_KEY to Railway Variables**
  - Go to: Railway Dashboard → Service → Variables
  - Add: `GEMINI_API_KEY` = your key
  - Get key from: https://makersuite.google.com/app/apikey

- [ ] **Verify Test Admin Account**
  - Try logging in: `test@speedjobs.com` / `password`
  - If fails, use Railway CLI or temporary route

- [ ] **Set Up Persistent Storage**
  - Choose Railway Volume OR Cloudinary
  - Required for banner images and resume uploads

### Verification Steps

After completing above:

1. **Test Login**
   - URL: `https://your-app.railway.app/login`
   - Email: `test@speedjobs.com`
   - Password: `password`

2. **Test AI Features**
   - AI Career Counselor: `/ai-counselor`
   - Career Assessment: `/assessments`
   - Resume Analysis: `/resume-analysis`
   - Interview Coach: `/interview-coach`

3. **Test Banner Images**
   - Admin Dashboard → Banners → Create Banner
   - Upload image
   - Check if displays on homepage

4. **Test Resume Upload**
   - Resume Analysis → Upload PDF
   - Should analyze and show results

## Railway Environment Variables Needed

```env
# App
APP_NAME="SpeedJobs Africa"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway auto-provides these)
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

# AI Features (YOU MUST ADD THIS)
GEMINI_API_KEY=your-gemini-api-key-here

# File Storage
FILESYSTEM_DISK=public
# OR if using Cloudinary:
# FILESYSTEM_DISK=cloudinary
# CLOUDINARY_URL=cloudinary://key:secret@cloud
```

## Common Issues & Solutions

### Issue: "These credentials do not match our records"
**Solution**: Test admin account not created
- Use Railway CLI to create manually
- Or wait for migration to run on next deployment

### Issue: "AI analysis failed"
**Solution**: GEMINI_API_KEY not set
- Add to Railway Variables
- Verify key is valid at https://makersuite.google.com/app/apikey

### Issue: Banner images not showing
**Solution**: Railway filesystem is ephemeral
- Set up Railway Volume or Cloudinary
- Re-upload images after setup

### Issue: Resume upload fails
**Solution**: Multiple possible causes
1. Add GEMINI_API_KEY
2. Set up persistent storage
3. Check Railway logs for specific error

## Files Created for You

1. ✅ `database/migrations/2026_02_15_000001_seed_test_admin.php` - Auto-creates admin
2. ✅ `nixpacks.toml` - Railway deployment config
3. ✅ `create-railway-admin.php` - Manual admin creation script
4. ✅ `RAILWAY_AI_FEATURES_FIX.md` - AI setup guide
5. ✅ `RAILWAY_CLI_SOLUTION.md` - Railway CLI instructions
6. ✅ `RAILWAY_BANNER_IMAGE_FIX.md` - Storage solutions

## Next Steps

1. **Right Now**: Add GEMINI_API_KEY to Railway Variables
2. **Then**: Verify test admin login works
3. **Then**: Set up persistent storage (Volume or Cloudinary)
4. **Finally**: Test all features

## Support

If issues persist:
1. Check Railway logs: Dashboard → Service → Deployments → Latest → Logs
2. Look for specific error messages
3. Verify all environment variables are set
4. Ensure migrations ran successfully

---

**Priority Order:**
1. 🔴 Add GEMINI_API_KEY (AI features won't work without this)
2. 🟡 Create test admin account (can't access admin features)
3. 🟡 Set up persistent storage (images/files won't persist)

Do step 1 first, then test AI features!
