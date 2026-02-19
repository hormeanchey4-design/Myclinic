# Deployment Checklist (Production)

## 1. Server Requirements
- PHP 7.4+ (recommended PHP 8.1+)
- MySQL 5.7+ or MariaDB equivalent
- Apache with `mod_rewrite` and `mod_headers`
- HTTPS certificate enabled

## 2. Upload Project
- Upload `clinic_system/` to your web root.
- Keep `uploads/` writable by web server.

## 3. Database Setup
- Create a new database (do not use default `root` user).
- Import `database.sql`.
- Change all demo account passwords after first login.

## 4. Environment Variables
Set these values in your hosting panel or Apache/Nginx config:
- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`
- `APP_BASE_URL` (example: `https://your-domain.com/clinic_system/`)

Use `.env.example` as reference.

## 5. Security Validation
- Confirm HTTPS is forced on your domain.
- Confirm `.htaccess` is active:
  - directory listing disabled
  - sensitive files blocked
  - dangerous script extensions blocked in `uploads/`
- Ensure `fix_passwords.php` is removed from production or blocked.

## 6. App Validation
- Register new patient account
- Login for all roles (admin/doctor/patient)
- Book appointment
- Update appointment status
- Add EMR record
- View + Print + Download PDF appointment detail
- Search by ID/Name works for doctor/patient lists

## 7. Backup and Monitoring
- Enable daily database backups
- Keep PHP/MySQL updated
- Monitor error logs (server + PHP)

## 8. Optional Recommended
- Add rate limiting for login endpoint
- Add email verification/reset password flow
- Add audit logs for critical actions (delete/update status)
