# Production Hardening Checklist

This checklist is for deploying `clinic_system` safely online.

## 1) Server & PHP
- Use PHP `8.2+`
- Turn off error display in production:
  - `display_errors=Off`
  - `log_errors=On`
- Enable HTTPS (valid SSL certificate)
- Enable Apache `mod_rewrite` and `AllowOverride All` for `.htaccess`

## 2) Database
- Use strong DB password (not empty root password)
- Limit DB user privileges to this app database only
- Backup DB daily (automated)
- Confirm schema contains:
  - `login_attempts` table
  - indexes added in `database.sql`

## 3) App Environment Variables
Set in Apache vhost or server env:
- `APP_BASE_URL`
- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`
- `ORTHANC_URL`
- `ORTHANC_USER`
- `ORTHANC_PASS`

## 4) Security Controls
- Confirm `uploads/.htaccess` is active (script execution blocked)
- Keep `csrf_token` enabled (already in code)
- Keep login rate-limit enabled (`login_attempts` table exists)
- Change default demo passwords immediately

## 5) File Permissions
- Writable only where needed:
  - `clinic_system/uploads/`
- Non-writable for application code files

## 6) PACS / Orthanc
- Verify Orthanc URL reachable from app server
- Verify sync from:
  - `admin/sync_imaging.php`
  - `doctor/sync_imaging.php`
- Confirm Study `View` opens Orthanc Explorer correctly

## 7) Functional Smoke Test
- Register + login (`admin`, `doctor`, `patient`)
- Book appointment + status update
- Add EMR + imaging result
- Print + PDF output check
- Profile photo upload / change / preview
- Doctor sees patient profile; patient sees doctor profile; admin sees both

## 8) Monitoring
- Track:
  - failed logins
  - PHP errors
  - PACS sync errors
- Keep at least 30 days of logs

