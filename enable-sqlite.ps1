# PowerShell script to enable SQLite in PHP

$phpIniPath = "C:\php\php.ini"

Write-Host "Enabling SQLite extensions in PHP..." -ForegroundColor Yellow

# Read the php.ini file
$content = Get-Content $phpIniPath -Raw

# Enable pdo_sqlite
$content = $content -replace ';extension=pdo_sqlite', 'extension=pdo_sqlite'

# Enable sqlite3
$content = $content -replace ';extension=sqlite3', 'extension=sqlite3'

# Write back to php.ini
Set-Content $phpIniPath $content

Write-Host "✅ SQLite extensions enabled!" -ForegroundColor Green
Write-Host ""
Write-Host "Now run these commands:" -ForegroundColor Cyan
Write-Host "  php artisan config:clear" -ForegroundColor White
Write-Host "  php artisan migrate" -ForegroundColor White
Write-Host "  php artisan serve" -ForegroundColor White
