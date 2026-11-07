@echo off
title UPI Gateway Terminal
cd /d "%~dp0"
set PATH=C:\Users\sahnu\.gemini\antigravity\scratch\tools\php;C:\Users\sahnu\.gemini\antigravity\scratch\tools\composer;C:\Users\sahnu\.gemini\antigravity\scratch\tools\nodejs;%PATH%

echo ====================================================
echo        UPI Gateway Development Environment
echo ====================================================
php -v
composer -V
node -v
echo ====================================================
echo You can run any 'php artisan', 'composer', or 'npm' command here.
echo.
cmd /k
