# 🔧 Railway Nixpacks Fix

## Problem
The `[phases.deploy]` section runs BEFORE `composer install`, causing the error:
```
Failed to open stream: No such file or directory in /app/vendor/autoload.php
```

## Solution
Move all deployment commands back to the `[start]` command, which runs AFTER all build phases complete.

## Fixed nixpacks.toml

```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer", "nodejs_20"]

[phases.install]
cmds = [
  "composer install --no-dev --optimize-autoloader --no-interaction"
]

[phases.build]
cmds = [
  "npm install",
  "npm run build"
]

[start]
cmd = "php artisan migrate --force && php artisan db:seed --class=TestAdminSeeder --force && php artisan storage:link && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT"
```

## Execution Order

1. ✅ Setup (install PHP, Composer, Node)
2. ✅ Install (composer install)
3. ✅ Build (npm install && npm run build)
4. ✅ Start (migrations → seeder → storage link → serve)

## Push This Fix

```bash
git add nixpacks.toml RAILWAY_NIXPACKS_FIX.md
git commit -m "Fix nixpacks deploy phase order"
git push
```

Railway will redeploy and the test admin account will be created automatically!

## After Deployment

Login with:
- Email: `test@speedjobs.com`
- Password: `password`

The account will be created during the start phase, right before the server starts.
