@echo off
title Push UPI Gateway to GitHub
cd /d "%~dp0"
set PATH=C:\Users\sahnu\.gemini\antigravity\scratch\tools\git\cmd;%PATH%

echo ====================================================
echo         Push UPI Gateway to Your GitHub
echo ====================================================
echo.
echo Pehle GitHub par ek nayi empty repository banayein.
echo Phir uska HTTPS link copy karein:
echo (Example: https://github.com/yourusername/upi-gateway.git)
echo.
set /p REPO_URL="Enter your GitHub Repository URL: "

if "%REPO_URL%"=="" (
    echo Error: Repository URL cannot be empty!
    pause
    exit /b
)

git remote remove origin 2>nul
git remote add origin %REPO_URL%
git branch -M main

echo.
echo Pushing to GitHub...
git push -u origin main

echo.
echo ====================================================
echo Push complete! Ab Render.com par jakar deploy karein.
echo ====================================================
pause
