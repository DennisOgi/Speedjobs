# 🔧 AI Career Counselor - Troubleshooting Guide

## 🚨 Issue: Buttons Not Working on AI Counselor Page

**Symptoms:**
- "Start New Conversation" button doesn't work
- Quick Start buttons (Career Advice, Interview Prep, etc.) don't work
- Clicking buttons does nothing or shows errors

---

## 🔍 Root Cause Analysis

After reviewing your implementation, I found **the main issue**:

### ❌ **DATABASE SERVER IS NOT RUNNING**

```
Error: SQLSTATE[HY000] [2002] No connection could be made because 
the target machine actively refused it
```

This means:
- MySQL/MariaDB server is not started
- The application cannot connect to the database
- All database operations fail
- Routes that need database access don't work

---

## ✅ Solution: Start Your Database Server

### For XAMPP Users:

1. **Open XAMPP Control Panel**
2. **Start MySQL** (click "Start" button next to MySQL)
3. **Verify it's running** (should show "Running" in green)

### For WAMP Users:

1. **Open WAMP Control Panel**
2. **Start All Services** (click the WAMP icon → Start All Services)
3. **Verify MySQL is running** (icon should be green)

### For Laragon Users:

1. **Open Laragon**
2. **Click "Start All"**
3. **Verify MySQL is running**

### For Standalone MySQL:

**Windows:**
```cmd
net start MySQL80
```

**Mac/Linux:**
```bash
sudo systemctl start mysql
# or
sudo service mysql start
```

---

## 🧪 Verify Database Connection

After starting your database server, run:

```bash
php diagnose-ai-counselor.php
```

You should see:
```
✅ Database connected successfully
Database: speedjobs
```

---

## 📋 Complete Setup Checklist

Once your database is running, follow these steps:

### Step 1: Start Database Server ⚠️
```
✅ Start MySQL/MariaDB
✅ Verify it's running
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

Expected output:
```
Migration table created successfully.
Migrating: 2026_02_05_000001_create_ai_conversations_table
Migrated:  2026_02_05_000001_create_ai_conversations_table
Migrating: 2026_02_05_000002_create_ai_messages_table
Migrated:  2026_02_05_000002_create_ai_messages_table
...
```

### Step 3: Add Gemini API Key
```bash
# Edit .env file and add:
GEMINI_API_KEY=your_actual_api_key_here
GEMINI_MODEL=gemini-1.5-flash
GEMINI_MAX_TOKENS=2048
GEMINI_TEMPERATURE=0.7
```

Get your API key from: https://aistudio.google.com/app/apikey

### Step 4: Create/Login User

**Option A: Register a new user**
1. Visit: http://localhost:8000/register
2. Fill in the form
3. Register

**Option B: Login with existing user**
1. Visit: http://localhost:8000/login
2. Enter credentials
3. Login

### Step 5: Make User Premium (Optional)

The routes are currently public for testing, but if you want to test premium features:

```bash
php artisan tinker
>>> $user = User::where('email', 'your@email.com')->first();
>>> $user->update(['is_paid' => true]);
>>> exit
```

Or via SQL:
```sql
UPDATE users SET is_paid = 1 WHERE email = 'your@email.com';
```

### Step 6: Test the Feature

1. **Start the server** (if not running):
   ```bash
   php artisan serve
   ```

2. **Visit**: http://localhost:8000/ai-counselor

3. **Click any button**:
   - "Start New Conversation"
   - "Career Advice"
   - "Interview Prep"
   - etc.

4. **Expected result**: You should be redirected to a chat interface

---

## 🐛 Other Common Issues

### Issue 1: "Route not found" Error

**Cause:** Routes not cached properly

**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

### Issue 2: "Class not found" Error

**Cause:** Autoload files not updated

**Solution:**
```bash
composer dump-autoload
```

### Issue 3: "CSRF token mismatch" Error

**Cause:** Session not working

**Solution:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan session:table
php artisan migrate
```

### Issue 4: Buttons Click But Nothing Happens

**Possible causes:**
1. JavaScript errors in browser console
2. Not logged in (check if you're authenticated)
3. Database connection lost

**Solution:**
1. Open browser console (F12)
2. Check for JavaScript errors
3. Verify you're logged in
4. Check database connection

### Issue 5: "Failed to get response from Gemini API"

**Cause:** API key not configured or invalid

**Solution:**
1. Check `.env` file has `GEMINI_API_KEY`
2. Verify API key is valid
3. Check API quota at: https://aistudio.google.com
4. Restart server after adding key

### Issue 6: "Unauthorized" or "Access Denied"

**Cause:** Not logged in or not premium user

**Solution:**
1. Login to your account
2. If routes require premium, set `is_paid = 1`
3. Check middleware in `routes/web.php`

---

## 🔍 Debugging Steps

### 1. Check Laravel Logs

```bash
# View last 50 lines of log
tail -n 50 storage/logs/laravel.log

# Or on Windows
Get-Content storage/logs/laravel.log -Tail 50
```

### 2. Check Browser Console

1. Open browser (Chrome/Firefox/Edge)
2. Press F12 to open Developer Tools
3. Go to "Console" tab
4. Look for red error messages
5. Check "Network" tab for failed requests

### 3. Test Routes Manually

```bash
# List all AI counselor routes
php artisan route:list --name=ai-counselor

# Test a specific route
php artisan route:list --name=ai-counselor.create
```

### 4. Test Database Connection

```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('users')->count();
>>> exit
```

### 5. Test Gemini Service

```bash
php artisan tinker
>>> $gemini = app(\App\Services\GeminiService::class);
>>> $response = $gemini->sendMessage("Test");
>>> print_r($response);
>>> exit
```

---

## 📊 Current Implementation Status

Based on my review, here's what's working:

### ✅ Working Features:
- Database schema (5 tables)
- Eloquent models (5 models)
- GeminiService (7+ methods)
- Controller (8 actions)
- Routes (8 routes registered)
- Views (dashboard + chat interface)
- Authorization policies

### ⚠️ Current Issues:
1. **Database server not running** ← MAIN ISSUE
2. API key not configured (optional for testing)
3. No users marked as premium (optional)

### 🔜 Not Yet Implemented:
- Assessment UI (backend ready)
- Career pathway UI (backend ready)
- Resume upload UI (backend ready)
- Interview coach UI (backend ready)
- Career insights dashboard

---

## 🎯 Quick Fix Summary

**To fix the buttons not working:**

1. **Start your database server** (XAMPP/WAMP/Laragon)
2. **Run migrations**: `php artisan migrate`
3. **Login or register** a user
4. **Test the buttons** - they should work now!

**Optional (for full functionality):**
5. Add Gemini API key to `.env`
6. Make user premium: `UPDATE users SET is_paid = 1`

---

## 📞 Still Having Issues?

If buttons still don't work after starting the database:

1. **Check browser console** (F12) for JavaScript errors
2. **Check Laravel logs**: `storage/logs/laravel.log`
3. **Verify you're logged in**: Check top-right corner of page
4. **Clear cache**: 
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```
5. **Restart server**:
   ```bash
   # Stop server (Ctrl+C)
   php artisan serve
   ```

---

## ✅ Expected Behavior

When everything is working correctly:

1. **Visit**: http://localhost:8000/ai-counselor
2. **See**: Dashboard with stats and quick action buttons
3. **Click**: Any button (e.g., "Career Advice")
4. **Result**: Redirected to chat interface with welcome message
5. **Type**: A message and press Enter
6. **Result**: AI responds with career advice

---

## 🎉 Success Indicators

You'll know it's working when:

✅ Database connection successful  
✅ Migrations run successfully  
✅ Can access /ai-counselor page  
✅ Buttons redirect to chat interface  
✅ Can send messages  
✅ AI responds (if API key configured)  

---

**Last Updated:** February 6, 2026  
**Status:** Database server not running - Start MySQL/MariaDB to fix
