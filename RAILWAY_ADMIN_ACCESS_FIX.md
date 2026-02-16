# Railway Admin Access - Quick Fix

## Problem
Getting "403 Unauthorized access. Admin privileges required" when trying to access admin dashboard on Railway.

## Solution Options

### Option 1: Use Test Admin Account (Recommended)

The system has a test admin account that should be created automatically. Try logging in with:

**Email:** test@speedjobs.com  
**Password:** password

If this doesn't work, the seeder didn't run. Use Option 2 or 3.

---

### Option 2: Make Your Current Account Admin (Easiest)

Use Railway CLI to run the artisan command:

1. **Install Railway CLI** (if not installed):
   ```bash
   npm install -g @railway/cli
   ```

2. **Login to Railway:**
   ```bash
   railway login
   ```

3. **Link to your project:**
   ```bash
   railway link
   ```
   Select your SpeedJobs project

4. **Make your account admin:**
   ```bash
   railway run php artisan user:make-admin your-email@example.com
   ```
   Replace `your-email@example.com` with the email you use to login

5. **Done!** Refresh the page and try accessing admin dashboard

---

### Option 3: Run the Test Admin Seeder

If you want to create the test admin account:

```bash
railway run php artisan db:seed --class=TestAdminSeeder
```

This creates:
- Email: test@speedjobs.com
- Password: password
- Admin: Yes
- Paid: Yes

---

### Option 4: Direct Database Update (Advanced)

If Railway CLI doesn't work, you can update the database directly:

1. Go to Railway dashboard
2. Click on your Postgres database
3. Go to "Data" tab
4. Find your user in the `users` table
5. Edit the row and set:
   - `is_admin` = `true` (or `1`)
   - `is_paid` = `true` (or `1`)
6. Save changes
7. Refresh your browser

---

## Verification

After making yourself admin, verify by:

1. Login to your account
2. Visit: `https://your-railway-url.up.railway.app/admin/dashboard`
3. Should see the admin dashboard with:
   - Statistics cards
   - User management
   - Banner management
   - Course management
   - Application management

---

## Quick Command Reference

```bash
# Make user admin
railway run php artisan user:make-admin email@example.com

# Run test admin seeder
railway run php artisan db:seed --class=TestAdminSeeder

# Check if user is admin (in tinker)
railway run php artisan tinker
>>> User::where('email', 'your@email.com')->first()->is_admin
```

---

## Recommended Approach

**For Testing:**
Use Option 1 (test@speedjobs.com / password)

**For Production:**
Use Option 2 to make your real account admin, then delete the test account

---

## After Getting Admin Access

Once you have admin access, you can:

1. **Manage Users**
   - View all registered users
   - Make other users admin
   - View user details

2. **Manage Banners**
   - Create training programs
   - Create events
   - Create workshops
   - Upload banner images

3. **Manage Courses**
   - Create course categories
   - Add new courses
   - Create lessons
   - Manage enrollments

4. **Review Applications**
   - Banner applications
   - Mentor applications
   - Counseling requests

5. **View Statistics**
   - Total users
   - Total jobs
   - Total applications
   - System overview

---

## Troubleshooting

**"Railway CLI not found"**
- Install it: `npm install -g @railway/cli`
- Or use direct database update (Option 4)

**"Project not linked"**
- Run: `railway link`
- Select your project from the list

**"User not found"**
- Make sure you're using the correct email
- Check spelling and case sensitivity

**"Command not found: user:make-admin"**
- The command exists in the code
- Make sure you're in the project directory
- Try: `railway run php artisan list` to see all commands

---

## Security Note

After setting up admin access:
1. Change the test admin password if using it
2. Don't share admin credentials
3. Use strong passwords for admin accounts
4. Consider removing test accounts in production

---

## Need Help?

If none of these options work:
1. Check Railway logs for errors
2. Verify database connection
3. Ensure migrations ran successfully
4. Contact support with error details
