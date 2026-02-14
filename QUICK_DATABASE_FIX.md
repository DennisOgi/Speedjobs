# ⚡ Quick Database Fix - 3 Simple Steps

## 🎯 The Problem
Your app can't connect to the database because SQLite driver is not enabled in PHP.

---

## ✅ FASTEST FIX (Choose One)

### Option A: Enable SQLite (2 minutes) ⭐ RECOMMENDED

**Step 1:** Run this PowerShell command as Administrator:
```powershell
powershell -ExecutionPolicy Bypass -File enable-sqlite.ps1
```

**Step 2:** Clear cache and run migrations:
```bash
php artisan config:clear
php artisan migrate
php artisan serve
```

**Done!** Visit http://127.0.0.1:8000

---

### Option B: Manual SQLite Enable (3 minutes)

**Step 1:** Open `C:\php\php.ini` in Notepad

**Step 2:** Find these lines (around line 900-950):
```ini
;extension=pdo_sqlite
;extension=sqlite3
```

**Step 3:** Remove the semicolons:
```ini
extension=pdo_sqlite
extension=sqlite3
```

**Step 4:** Save and close

**Step 5:** Run commands:
```bash
php artisan config:clear
php artisan migrate
php artisan serve
```

**Done!** Visit http://127.0.0.1:8000

---

### Option C: Switch to MySQL (5 minutes)

**Step 1:** Make sure MySQL/MariaDB is running

**Step 2:** Create database:
```sql
CREATE DATABASE speedjobs;
```

**Step 3:** Update `.env` file - change these lines:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=speedjobs
DB_USERNAME=root
DB_PASSWORD=
```

**Step 4:** Run commands:
```bash
php artisan config:clear
php artisan migrate
php artisan serve
```

**Done!** Visit http://127.0.0.1:8000

---

## 🧪 Verify It Works

After applying any fix, test with:

```bash
php artisan migrate:status
```

You should see:
```
Migration name                                    Batch / Status
2026_02_05_000001_create_ai_conversations_table   [1] Ran
2026_02_05_000002_create_ai_messages_table        [1] Ran
...
```

---

## 🎉 What I Already Fixed

✅ Changed `SESSION_DRIVER` from `database` to `file` in your `.env`  
✅ This allows the app to start even if database isn't working yet  
✅ Created `enable-sqlite.ps1` script for easy SQLite activation

---

## 💡 My Recommendation

**Use Option A** (PowerShell script) - It's the fastest and easiest!

Just run:
```powershell
powershell -ExecutionPolicy Bypass -File enable-sqlite.ps1
php artisan config:clear
php artisan migrate
php artisan serve
```

Then visit: http://127.0.0.1:8000

---

## 🆘 Still Having Issues?

If you get permission errors running the PowerShell script:

1. Right-click PowerShell
2. Select "Run as Administrator"
3. Run the script again

Or just use **Option B** (manual edit) - it's foolproof!

---

**Need help?** Check `FIX_DATABASE_ERROR.md` for more detailed instructions.
