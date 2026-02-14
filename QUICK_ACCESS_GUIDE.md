# Quick Access Guide

## Admin Dashboard Access

### Option 1: Quick Script (Easiest)
```bash
php make-admin.php
```

### Option 2: Artisan Tinker
```bash
php artisan tinker
```
Then:
```php
$user = User::where('email', 'test@speedjobs.com')->first();
$user->is_admin = true;
$user->save();
exit;
```

### Access URL
After granting admin access, visit:
```
http://127.0.0.1:8000/admin/dashboard
```

### Test Credentials
- **Email**: test@speedjobs.com
- **Password**: password

---

## Troubleshooting Career Intelligence Report

### If Report Doesn't Load:

1. **Open Browser Console** (F12)
   - Look for "Report data received:" log
   - Check for any error messages

2. **Verify User Status**
   ```bash
   php artisan tinker
   ```
   ```php
   $user = User::where('email', 'test@speedjobs.com')->first();
   echo "Is Paid: " . ($user->is_paid ? 'Yes' : 'No') . "\n";
   echo "Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
   exit;
   ```

3. **Check Gemini API Key**
   ```bash
   php artisan tinker
   ```
   ```php
   echo "API Key: " . (config('services.gemini.api_key') ? 'Set' : 'Missing') . "\n";
   exit;
   ```

4. **Force Refresh**
   - Click the "Refresh Analysis" button on dashboard
   - This generates a new report

5. **Check API Quota**
   - Gemini free tier: 20 requests/day
   - If exceeded, wait 24 hours or upgrade

---

## All Dashboard URLs

### User Dashboards
- **Jobseeker**: `/dashboard`
- **Employer**: `/employer/dashboard`
- **Admin**: `/admin/dashboard`

### AI Features
- **AI Career Counselor**: `/ai-counselor`
- **Career Assessment**: `/assessments`
- **Interview Prep**: `/ai-counselor` (select Interview Prep)
- **Resume Analysis**: `/resume-analysis`
- **Career Planning**: `/career-planning`

### Job Features
- **Find Jobs**: `/jobs`
- **Post Job**: `/jobs/create`
- **My Applications**: `/applications`
- **Saved Jobs**: `/saved-jobs`

### Career Services
- **Career Services**: `/career-services`
- **Resume Builder**: `/resume/create`
- **Workshops**: `/workshops`
- **Mentorship**: `/mentorship`

---

## Quick Commands

### Make User Admin
```bash
php make-admin.php
```

### Make User Paid
```bash
php artisan tinker
```
```php
$user = User::where('email', 'test@speedjobs.com')->first();
$user->is_paid = true;
$user->save();
exit;
```

### Clear Cache
```bash
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Run Migrations
```bash
php artisan migrate
```

### Seed Database
```bash
php artisan db:seed
```

---

## Testing Checklist

### ✅ Resume Builder
- [ ] Template selector scrolls properly
- [ ] Mobile template icon works
- [ ] Templates change preview
- [ ] PDF download works

### ✅ Admin Dashboard
- [ ] Can access `/admin/dashboard`
- [ ] All 7 sections load
- [ ] Can manage users
- [ ] Can manage banners

### ✅ Employer Dashboard
- [ ] Stats display correctly
- [ ] Can post jobs
- [ ] Can view applications
- [ ] Can update application status

### ✅ Career Intelligence Report
- [ ] Report loads on dashboard
- [ ] All sections display
- [ ] Refresh button works
- [ ] No console errors

---

## Common Issues & Solutions

### Issue: "Route [admin.dashboard] not defined"
**Solution**: User doesn't have admin access. Run `php make-admin.php`

### Issue: "Premium feature required"
**Solution**: User isn't paid. Set `is_paid = true` in database

### Issue: Career Report shows "Failed to load"
**Solutions**:
1. Check Gemini API key in `.env`
2. Verify user is paid
3. Check browser console for errors
4. Try refresh button
5. Check API quota limits

### Issue: Templates not showing in dropdown
**Solution**: Clear cache with `php artisan view:clear`

### Issue: Can't update job/application
**Solution**: Verify user owns the resource (authorization check)

---

## Support Files

- `FINAL_FIXES_SUMMARY.md` - Detailed fix documentation
- `ADMIN_ACCESS_GUIDE.md` - Complete admin guide
- `ADMIN_DASHBOARD_REVIEW_COMPLETE.md` - Admin feature review
- `UI_CLEANUP_COMPLETE.md` - Recent UI changes
- `MOBILE_OPTIMIZATIONS_COMPLETE.md` - Mobile improvements

---

**Last Updated**: February 12, 2026
