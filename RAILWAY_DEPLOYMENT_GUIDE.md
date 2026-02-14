# Railway Deployment Guide for SpeedJobs Africa

## ✅ What's Already Done

1. **TestAdminSeeder Added** - Automatically creates test admin account on deployment
2. **Banner Image Paths Fixed** - All views now use correct `storage/` prefix

## 🚀 Railway Setup Steps

### 1. Initial Deployment

When you push to your repo, Railway automatically:
- Detects Laravel application
- Runs `composer install`
- Runs migrations
- Builds and deploys

### 2. Environment Variables

Make sure these are set in Railway dashboard:

```env
APP_NAME="SpeedJobs Africa"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=your-railway-mysql-host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-railway-mysql-password

GEMINI_API_KEY=your-gemini-api-key

FILESYSTEM_DISK=public
```

### 3. Storage Symlink Issue (CRITICAL)

Railway's filesystem is **ephemeral** - files uploaded during runtime are lost on redeploy. This is why banner images disappear.

**Solutions:**

#### Option A: Use Railway Volumes (Recommended)
1. In Railway dashboard, go to your service
2. Click "Variables" tab
3. Add a Volume:
   - Mount Path: `/app/storage/app/public`
   - Size: 1GB (or as needed)

#### Option B: Use External Storage (Best for Production)
Use AWS S3, Cloudinary, or similar:

1. Install Laravel filesystem driver:
```bash
composer require league/flysystem-aws-s3-v3
```

2. Update `.env`:
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

3. Update `config/filesystems.php` if needed

### 4. Run Post-Deployment Commands

Railway should run these automatically, but verify in your `Procfile` or Railway settings:

```bash
# Run migrations
php artisan migrate --force

# Seed test admin account
php artisan db:seed --class=TestAdminSeeder --force

# Create storage symlink
php artisan storage:link

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Create Procfile (if not exists)

Create `Procfile` in root:
```
web: php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link && php artisan config:cache && php -S 0.0.0.0:$PORT -t public
```

Or use Railway's nixpacks build:
```
release: php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link
```

## 🔐 Test Admin Credentials

After deployment, you can login with:

```
Email: test@speedjobs.com
Password: password
```

This account has:
- ✅ Admin privileges
- ✅ Paid status
- ✅ Full access to all features

## 📁 Banner Image Storage

### Current Issue
Banner images stored in `storage/app/public/banners/` are lost on Railway redeploy because the filesystem is ephemeral.

### Temporary Solution (Testing)
1. After each deployment, re-upload banner images via admin dashboard
2. Images are stored in database with path like `banners/filename.jpg`
3. Displayed using `asset('storage/banners/filename.jpg')`

### Permanent Solution
Implement Option B above (External Storage like S3)

## 🔧 Troubleshooting

### Images Not Displaying
1. Check if storage symlink exists:
```bash
railway run php artisan storage:link
```

2. Verify file permissions:
```bash
railway run ls -la storage/app/public
```

3. Check if files exist:
```bash
railway run ls -la storage/app/public/banners
```

### Database Issues
```bash
# Check migrations
railway run php artisan migrate:status

# Re-run migrations
railway run php artisan migrate:fresh --seed --force
```

### Clear All Caches
```bash
railway run php artisan optimize:clear
```

## 📝 Notes

- Railway automatically redeploys when you push to your connected repo
- Environment variables persist across deployments
- Database data persists (if using Railway MySQL)
- **File uploads do NOT persist** without volumes or external storage
- Test admin account is recreated/updated on each deployment via seeder

## 🎯 Next Steps

1. ✅ Push code to trigger Railway deployment
2. ✅ Verify test admin login works
3. ⚠️ Set up Railway Volume or S3 for persistent file storage
4. ✅ Upload banner images via admin dashboard
5. ✅ Test all features with test admin account

## 🔗 Useful Railway Commands

```bash
# View logs
railway logs

# Run artisan commands
railway run php artisan [command]

# SSH into container
railway shell

# Link local project to Railway
railway link
```
