# Admin Dashboard Access Guide

## Quick Start

### Step 1: Make Your Test User an Admin

Run this command in your terminal:

```bash
php artisan tinker
```

Then paste this code:

```php
$user = User::where('email', 'test@speedjobs.com')->first();
$user->is_admin = true;
$user->save();
echo "Admin status granted!\n";
exit;
```

### Step 2: Access the Admin Dashboard

1. Open your browser
2. Go to: `http://127.0.0.1:8000/admin/dashboard`
3. Login with:
   - **Email:** `test@speedjobs.com`
   - **Password:** `password`

---

## Admin Dashboard Features

### 📊 Dashboard Overview
**URL:** `/admin/dashboard`

View real-time statistics:
- Total Users: 52
- Total Jobs: 50
- Active Banners: 5
- Pending Counseling Requests
- Recent activity

### 🎨 Banner Management
**URL:** `/admin/banners`

- Create new banners
- Edit existing banners
- Upload banner images
- Set active/inactive status
- Schedule banner display dates
- Manage display order

### 👥 User Management
**URL:** `/admin/users`

- View all registered users
- Edit user profiles
- Grant/revoke admin access
- Toggle paid status
- Manage user roles

### 💼 Counseling Requests
**URL:** `/admin/counseling`

- View all counseling requests
- See request details
- Assign counselors
- Update request status
- Filter by status

### 🎓 Workshop Management
**URL:** `/admin/workshops`

- Create workshops
- Edit workshop details
- View registrations
- Approve/reject registrations
- Manage capacity

### 📚 Resource Management
**URL:** `/admin/resources`

- Upload resources (PDFs, docs)
- Categorize resources
- Set access level (free/paid)
- Delete resources

### 📋 Banner Applications
**URL:** `/admin/banner-applications`

- View programme applications
- Review application details
- Approve applications
- Reject applications
- Track application status

---

## Quick Actions Menu

The dashboard includes quick action buttons for:

1. **Counseling** - Manage counseling requests
2. **Banners** - Manage banner ads
3. **Resources** - Manage downloadable files
4. **Jobs** - View job listings
5. **Users** - Manage user accounts
6. **Workshops** - Manage events
7. **Applications** - Review programme applications

---

## Admin Middleware

The admin dashboard is protected by the `IsAdmin` middleware. Only users with `is_admin = true` can access admin routes.

### Protected Routes:
- `/admin/*` - All admin routes
- Requires authentication
- Requires admin status

---

## Creating Additional Admins

### Method 1: Via Tinker (Recommended)
```bash
php artisan tinker
```

```php
$user = User::where('email', 'user@example.com')->first();
$user->is_admin = true;
$user->save();
```

### Method 2: Via Artisan Command
Create a command file: `app/Console/Commands/MakeAdmin.php`

```bash
php artisan make:admin user@example.com
```

### Method 3: During Registration
Modify the registration controller to set admin status for specific emails.

---

## Security Best Practices

### 1. Strong Passwords
- Use strong passwords for admin accounts
- Change default passwords immediately

### 2. Limited Admin Access
- Only grant admin access to trusted users
- Regularly review admin user list

### 3. Activity Monitoring
- Monitor admin actions
- Review recent changes regularly

### 4. Backup Before Changes
- Backup database before bulk operations
- Test changes in development first

---

## Troubleshooting

### Can't Access Admin Dashboard?

**Problem:** "403 Forbidden" or redirected to home

**Solution:**
1. Check if user has admin status:
   ```bash
   php artisan tinker
   User::where('email', 'test@speedjobs.com')->value('is_admin');
   ```

2. If returns `0` or `null`, grant admin:
   ```php
   $user = User::where('email', 'test@speedjobs.com')->first();
   $user->is_admin = true;
   $user->save();
   ```

### Not Logged In?

**Solution:**
1. Go to `/login`
2. Login with test credentials
3. Then navigate to `/admin/dashboard`

### Database Error?

**Solution:**
1. Check if migrations are run:
   ```bash
   php artisan migrate:status
   ```

2. If needed, run migrations:
   ```bash
   php artisan migrate
   ```

---

## Admin Dashboard Statistics

Current system stats (as of review):

| Metric | Count |
|--------|-------|
| Total Users | 52 |
| Admin Users | 0 (create one!) |
| Paid Users | 1 |
| Total Jobs | 50 |
| Active Banners | 5 |
| Counseling Requests | 0 |
| Workshops | 0 |
| Resources | 0 |

---

## Next Steps After Access

1. ✅ **Explore Dashboard** - Familiarize yourself with the interface
2. ✅ **Create Test Data** - Add workshops, resources
3. ✅ **Test Features** - Try creating/editing/deleting
4. ✅ **Review Users** - Check user list and permissions
5. ✅ **Configure Banners** - Update banner content
6. ✅ **Add Resources** - Upload helpful documents
7. ✅ **Create Workshops** - Schedule events

---

## Support

If you encounter any issues:

1. Check the `COMPREHENSIVE_REVIEW_REPORT.md` for system status
2. Review `TROUBLESHOOTING_GUIDE.md` for common issues
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database connection: `php artisan tinker` then `DB::connection()->getPdo();`

---

**Last Updated:** February 10, 2026  
**System Status:** ✅ All Features Operational  
**Admin Dashboard:** ✅ Fully Functional
