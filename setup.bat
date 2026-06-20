@echo off
ECHO ================================================
ECHO Alumni Nexus - Setup Script
ECHO ================================================
ECHO.

REM Check if we're in the right directory
IF NOT EXIST "artisan" (
    ECHO Error: Please run this script from the Alumni-project directory
    ECHO Current directory: %CD%
    PAUSE
    EXIT /B 1
)

ECHO Step 1: Checking Composer...
WHERE composer >nul 2>nul
IF %ERRORLEVEL% NEQ 0 (
    ECHO [WARNING] Composer not found in PATH
    ECHO Please install Composer from https://getcomposer.org/
    PAUSE
    EXIT /B 1
)
ECHO [OK] Composer found

ECHO.
ECHO Step 2: Installing PHP dependencies...
composer install --no-interaction
IF %ERRORLEVEL% NEQ 0 (
    ECHO [ERROR] Failed to install dependencies
    PAUSE
    EXIT /B 1
)
ECHO [OK] Dependencies installed

ECHO.
ECHO Step 3: Checking MySQL connection...
c:\xampp\mysql\bin\mysql.exe -u root -e "SELECT 1;" >nul 2>nul
IF %ERRORLEVEL% NEQ 0 (
    ECHO [WARNING] Cannot connect to MySQL
    ECHO Please ensure MySQL is running in XAMPP Control Panel
    ECHO After starting MySQL, press any key to continue...
    PAUSE >nul
    
    REM Try again
    c:\xampp\mysql\bin\mysql.exe -u root -e "SELECT 1;" >nul 2>nul
    IF %ERRORLEVEL% NEQ 0 (
        ECHO [ERROR] Still cannot connect to MySQL
        ECHO Please start MySQL manually and run: php artisan migrate
        PAUSE
        EXIT /B 1
    )
)
ECHO [OK] MySQL is running

ECHO.
ECHO Step 4: Creating database...
c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS alumni_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
IF %ERRORLEVEL% NEQ 0 (
    ECHO [WARNING] Could not create database
    ECHO You may need to create it manually in phpMyAdmin
) ELSE (
    ECHO [OK] Database created
)

ECHO.
ECHO Step 5: Running migrations...
php artisan migrate --force
IF %ERRORLEVEL% NEQ 0 (
    ECHO [ERROR] Migration failed
    ECHO Please check your database configuration in .env file
    PAUSE
    EXIT /B 1
)
ECHO [OK] Migrations completed

ECHO.
ECHO Step 6: Would you like to seed sample data? (Y/N)
SET /P SEED_CHOICE="Enter your choice: "
IF /I "%SEED_CHOICE%"=="Y" (
    ECHO Seeding sample data...
    php artisan db:seed
    IF %ERRORLEVEL% NEQ 0 (
        ECHO [WARNING] Seeding failed or was skipped
    ) ELSE (
        ECHO [OK] Sample data seeded successfully
    )
) ELSE (
    ECHO [INFO] Skipping sample data seeding
)

ECHO.
ECHO ================================================
ECHO Setup Complete!
ECHO ================================================
ECHO.
ECHO To start the application, run:
ECHO     php artisan serve
ECHO.
ECHO Then open your browser to:
ECHO     http://localhost:8000
ECHO.
ECHO ================================================
PAUSE
