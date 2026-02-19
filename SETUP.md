# 🏥 Clinic Management System - Setup Guide

Complete step-by-step guide to set up and run the Clinic Management System.

## Prerequisites

- Windows/Mac/Linux operating system
- XAMPP installed ([Download here](https://www.apachefriends.org/))
- Basic knowledge of web servers and databases

## Installation Steps

### 1. Install XAMPP

#### Windows:
1. Download XAMPP installer from https://www.apachefriends.org/
2. Run the installer
3. Select Apache, MySQL, PHP, and PHPMyAdmin during installation
4. Choose installation directory (usually `C:\xampp`)
5. Complete installation

#### Mac:
1. Download XAMPP for Mac
2. Open DMG file and copy XAMPP to Applications folder

#### Linux:
```bash
cd /opt
wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/.../xampp-linux-*.tar.gz
tar xvfz xampp-linux-*.tar.gz
```

### 2. Start XAMPP Services

#### Windows:
1. Open XAMPP Control Panel
2. Click "Start" for Apache
3. Click "Start" for MySQL

#### Mac/Linux:
```bash
sudo /Applications/XAMPP/xamppfiles/bin/apachectl start
/Applications/XAMPP/xamppfiles/bin/mysql.server start
```

### 3. Verify Installation

1. Open browser: `http://localhost`
2. You should see XAMPP dashboard
3. Open: `http://localhost/phpmyadmin`
4. You should see phpMyAdmin interface

### 4. Create Database

1. Go to `http://localhost/phpmyadmin`
2. Click on "SQL" tab
3. Copy entire content from `clinic_system/database.sql`
4. Paste in SQL editor and click "Go"
5. Wait for success message

Or using command line:
```bash
cd C:\xampp\mysql\bin
mysql -u root -p
# If prompted for password, just press Enter (default is no password)
SOURCE C:\xampp\htdocs\projcet2026\clinic_system\database.sql;
```

### 5. Verify Database Created

1. Go to phpMyAdmin
2. Look for `clinic_system` database in left sidebar
3. Expand it to see tables:
   - users
   - appointments
   - medical_records
   - doctor_schedules
   - notifications

### 6. Access the System

1. In browser, go to: `http://localhost/projcet2026/clinic_system/`
2. You should see the home page with login/register options

## First Time Usage

### Admin Login
1. Click "Login" on home page
2. Enter:
   - Email: `admin@clinic.com`
   - Password: `admin123`
3. Click "Login"
4. You're now in Admin Dashboard

### Doctor Login
1. Click "Login" on home page
2. Enter:
   - Email: `doctor@clinic.com`
   - Password: `doctor123`
3. Click "Login"
4. You're now in Doctor Dashboard

### Patient Login
1. Click "Login" on home page
2. Enter:
   - Email: `patient@clinic.com`
   - Password: `patient123`
3. Click "Login"
4. You're now in Patient Dashboard

## Common Issues & Solutions

### Issue: "Connection failed" error

**Problem**: Cannot connect to MySQL database

**Solution**:
1. Ensure MySQL is running in XAMPP Control Panel
2. Check database credentials in `config/db.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";  // Default is empty
   $db   = "clinic_system";
   ```

### Issue: Database not created

**Problem**: `clinic_system` database not appearing

**Solution**:
1. Go to phpMyAdmin
2. Create database manually:
   - Click "New"
   - Database name: `clinic_system`
   - Encoding: utf8_general_ci
   - Click "Create"
3. Import database.sql file

### Issue: Blank white page

**Problem**: Page shows nothing

**Solution**:
1. Check if all files are in correct folders
2. Verify database connection is successful
3. Check Apache error logs in XAMPP
4. Ensure PHP is enabled

### Issue: Login page shows but login fails

**Problem**: Cannot login with demo accounts

**Solution**:
1. Verify database tables have correct data
2. Check users table in phpMyAdmin
3. Ensure database.sql was imported completely
4. Try creating new account via Register page

### Issue: Admin page shows but some features missing

**Problem**: Not all menu items visible

**Solution**:
1. Clear browser cache (Ctrl+Shift+Delete)
2. Log out and log back in
3. Ensure all .php files exist in folders

## Testing the System

### Patient Flow:
1. Login as patient (patient@clinic.com)
2. Click "Book Appointment"
3. Select doctor, date, time, and reason
4. Click "Book Appointment"
5. Go to "My Appointments" to verify

### Doctor Flow:
1. Login as doctor (doctor@clinic.com)
2. Go to "My Appointments"
3. Click on an appointment to view details
4. Go to "Add EMR" to add medical record
5. Fill diagnosis, prescription, etc.
6. Save medical record

### Admin Flow:
1. Login as admin (admin@clinic.com)
2. View "Dashboard" for statistics
3. Go to "Manage Doctors" to add/edit doctors
4. Go to "Manage Patients" to add/edit patients
5. Go to "Appointments" to manage all appointments
6. Go to "Reports" to see analytics

## File Locations

| File | Location |
|------|----------|
| Home Page | `http://localhost/projcet2026/clinic_system/index.php` |
| Admin Dashboard | `http://localhost/projcet2026/clinic_system/admin/dashboard.php` |
| Doctor Dashboard | `http://localhost/projcet2026/clinic_system/doctor/dashboard.php` |
| Patient Dashboard | `http://localhost/projcet2026/clinic_system/patient/dashboard.php` |
| Database | `clinic_system` in MySQL |

## Next Steps

1. **Customize Settings**: Modify colors and styles in `includes/header.php`
2. **Add More Doctors**: Go to Admin > Manage Doctors
3. **Invite Users**: Share registration link with doctors and patients
4. **Configure Notifications**: Set up SMS/Email (optional)
5. **Setup Backup**: Create regular database backups

## Useful Commands

### MySQL Commands

View databases:
```sql
SHOW DATABASES;
```

Select database:
```sql
USE clinic_system;
```

View tables:
```sql
SHOW TABLES;
```

View users:
```sql
SELECT * FROM users;
```

Check MySQL version:
```bash
mysql --version
```

### PHP Commands

Check PHP version:
```bash
php --version
```

Run PHP development server:
```bash
php -S localhost:8000
```

## Security Notes

⚠️ **Important for Production**:
1. Change all demo account passwords
2. Use strong passwords (minimum 12 characters)
3. Enable HTTPS/SSL certificate
4. Set up firewall rules
5. Regular database backups
6. Keep PHP and MySQL updated

## Getting Help

1. Check README.md in clinic_system folder
2. Review database structure in database.sql
3. Check error logs in XAMPP
4. Verify file permissions
5. Test with demo accounts first

## Quick Reference

| URL | Description |
|-----|-------------|
| `localhost/phpmyadmin` | Database Management |
| `localhost/projcet2026/clinic_system/` | System Home |
| `localhost/projcet2026/clinic_system/auth/login.php` | Login Page |
| `localhost/projcet2026/clinic_system/auth/register.php` | Register Page |

---

**You're all set!** 🎉

Start exploring the Clinic Management System with the demo accounts provided. Good luck!
