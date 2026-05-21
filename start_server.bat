@echo off
echo =======================================================
echo Starting Emergency Medical System Local Server...
echo =======================================================
echo.
echo The server is running on: http://localhost:8000
echo Do not close this window while using the application.
echo To stop the server, press Ctrl+C.
echo.
cd /d "%~dp0"

REM Check if php is in PATH
php -v >nul 2>&1
IF %ERRORLEVEL% EQU 0 (
    echo Using system PHP...
    php -S localhost:8000 -t public
    pause
    exit /b
)

REM Check common XAMPP path
IF EXIST "C:\xampp\php\php.exe" (
    echo Using XAMPP PHP...
    "C:\xampp\php\php.exe" -S localhost:8000 -t public
    pause
    exit /b
)

echo.
echo [ERROR] PHP is not installed or not added to your system PATH!
echo If you have XAMPP installed, please make sure it is in C:\xampp\
echo Otherwise, please install XAMPP from https://www.apachefriends.org/
echo.
pause
