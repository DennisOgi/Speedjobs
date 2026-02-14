# 🔧 Fix Database Error - "could not find driver"

## Problem
Your application is configured to use SQLite, but PHP doesn't have the SQLite extension enabled.

---

## ✅ SOLUTION 1: Enable SQLite (Quick Fix - 2 minutes)

### Step 1: Find your php.ini file
```bash
php --ini
```

Look for "Loaded Configuration File" in the output.

### Step 2: Edit php.ini
Open the php.ini file and find these lines:

```ini
;extension=pdo_sqlite
;extension=sqlite3
```

**Remove the semicolons** to enable them:

```ini
extension=pdo_sqlite
extension=sqlite3
```

### Step 3: Restart your server
```bash
# Stop the server (Ctrl+C if running)
# Then start again:
php artisan serve
```

### Step 4: Run migrations
```bash
php artisan migrate
```

---

## ✅ SOLUTION 2: Switch to MySQL (Recommended for Production)

### Step 1: Start MySQL/MariaDB
Make sure your MySQL or MariaDB server is running.

### Step 2: Create database
```sql
CREATE DATABASE speedjobs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 3: Update .env file
Replace the database section with:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=speedjobs
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Clear config cache
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 5: Run migrations
```bash
php artisan migrate
```

---

## ✅ SOLUTION 3: Use File-Based Sessions (Quick Workaround)

If you just want to test quickly without fixing the database:

### Update .env
Change this line:
```env
SESSION_DRIVER=database
```

To:
```env
SESSION_DRIVER=file
```

### Clear cache
```bash
php artisan config:clear
```

### Restart server
```bash
php artisan serve
```

**Note:** This only fixes sessions. You still need a working database for the AI Counselor feature.

---

## 🎯 Recommended Approach

**For Development/Testing:**
- Use **Solution 1** (Enable SQLite) - Easiest and fastest

**For Production:**
- Use **Solution 2** (MySQL) - More robust and scalable

**For Quick Testing:**
- Use **Solution 3** (File sessions) + **Solution 1 or 2** for database

---

## 🧪 Verify It's Fixed

After applying any solution, test with:

```bash
php artisan migrate:status
```

You should see a list of migrations without errors.

Then visit: http://127.0.0.1:8000

---

## 💡 Quick Fix Command (All-in-One)

If you want to quickly switch to file sessions and MySQL:

```bash
# Update .env (do this manually or use the command below)
# Then run:
php artisan config:clear
php artisan cache:clear
php artisan migrate
php artisan serve
```

---

**Choose the solution that works best for your setup!**
