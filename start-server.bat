@echo off
title UPI Gateway Server
cd /d "%~dp0"
set PATH=C:\Users\sahnu\.gemini\antigravity\scratch\tools\php;C:\Users\sahnu\.gemini\antigravity\scratch\tools\composer;C:\Users\sahnu\.gemini\antigravity\scratch\tools\nodejs;%PATH%

echo ====================================================
echo        Starting UPI Gateway Local Server...
echo ====================================================
echo.
echo URL: http://127.0.0.1:8000
echo Admin Email:    admin@example.com
echo Admin Password: Password@1234
echo.
echo Opening browser in 2 seconds...
timeout /t 2 >nul
start "" "http://127.0.0.1:8000"
php artisan serve --port=8000
pause
