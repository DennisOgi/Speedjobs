# 🚀 Quick Railway Reference

## Push Changes
```bash
git add .
git commit -m "Railway deployment ready"
git push
```

## Test Admin Login (Available Immediately After Deploy)
```
URL: https://your-app.railway.app/login
Email: test@speedjobs.com
Password: password
```

## Fix Banner Images (Choose ONE)

### Option 1: Railway Volume (5 minutes)
1. Railway Dashboard → Service → Settings → Volumes
2. Click "New Volume"
3. Mount Path: `/app/storage/app/public`
4. Size: 1GB
5. Save → Redeploy

### Option 2: Cloudinary (15 minutes)
```bash
composer require cloudinary-labs/cloudinary-laravel
```

Railway Environment Variables:
```
FILESYSTEM_DISK=cloudinary
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
```

## Verify Deployment
```bash
# Check if test admin exists
railway run php artisan tinker
>>> User::where('email', 'test@speedjobs.com')->first()

# Check storage symlink
railway run ls -la public/storage

# View logs
railway logs
```

## Common Issues

### Images not showing?
→ Set up Railway Volume or Cloudinary (see above)

### Can't login?
→ Check Railway logs: `railway logs`
→ Verify database connected in Railway dashboard

### 500 Error?
→ Check APP_KEY is set in Railway environment variables
→ Run: `railway run php artisan key:generate --show`

## Files Changed
- ✅ `database/seeders/DatabaseSeeder.php` - Auto-seed test admin
- ✅ `resources/views/components/banner-slider.blade.php` - Fixed image path
- ✅ `nixpacks.toml` - Railway deployment config

## Auto-Runs on Every Deploy
1. Migrations
2. Test admin seeder
3. Storage symlink
4. Config cache

## That's It!
Push → Wait 2-3 minutes → Login → Set up storage → Upload banners → Done! 🎉
