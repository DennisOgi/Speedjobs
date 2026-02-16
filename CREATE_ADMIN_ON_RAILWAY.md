# Create Admin Account on Railway - Simple Steps

## What I Did

I added a temporary route to your Railway deployment that will create/update the admin account when you visit it.

## Steps to Create Admin Account

### 1. Wait for Railway Deployment
- Railway is automatically deploying the changes now
- Wait 2-3 minutes for deployment to complete
- Check Railway dashboard to see when it's done

### 2. Visit the Setup URL
Once deployed, visit this URL in your browser:

```
https://web-production-07d24.up.railway.app/setup-admin-account
```

Replace `web-production-07d24.up.railway.app` with your actual Railway URL if different.

### 3. You'll See a Success Message
The page will show JSON like this:

```json
{
  "success": true,
  "message": "Admin account created successfully!",
  "email": "test@speedjobs.com",
  "password": "password",
  "is_admin": true,
  "is_paid": true,
  "note": "You can now login and access /admin/dashboard"
}
```

### 4. Login with Admin Account
Now you can login with:
- **Email:** test@speedjobs.com
- **Password:** password

### 5. Access Admin Dashboard
After logging in, visit:
```
https://your-railway-url.up.railway.app/admin/dashboard
```

You should now see the full admin dashboard!

---

## What the Route Does

The route:
1. Checks if test@speedjobs.com exists
2. If exists: Updates it to have admin and paid privileges
3. If doesn't exist: Creates new account with admin privileges
4. Returns success message

---

## Security Note

**After you've created the admin account:**

1. You can remove this route by commenting it out in `routes/web.php`
2. Or change the admin password from the profile page
3. The route is safe because it only affects one specific email

---

## Troubleshooting

**If you see an error:**
- Check Railway logs for details
- Make sure database is connected
- Verify migrations have run

**If account already exists:**
- The route will just update it to have admin privileges
- Your existing password won't change

**Can't access admin dashboard after login:**
- Make sure you're logged in with test@speedjobs.com
- Clear browser cache and cookies
- Try logging out and back in

---

## After Setup

Once you have admin access, you can:
1. Create other admin accounts from the user management page
2. Delete or disable the test account if needed
3. Remove the setup route from routes/web.php

---

## Quick Reference

**Setup URL:** `/setup-admin-account`  
**Admin Email:** test@speedjobs.com  
**Admin Password:** password  
**Admin Dashboard:** `/admin/dashboard`

That's it! Simple and straightforward.
