# Pre-Launch Final Checklist

Run this before going live.

## Configuration
- `APP_BASE_URL` is set to production domain (HTTPS).
- DB env vars are set to non-root credentials.
- `.htaccess` works (sensitive files blocked).
- `fix_passwords.php` is removed or blocked.

## Security
- HTTPS active on all routes.
- Admin/Doctor/Patient logins work.
- Session works after login/logout.
- CSRF-protected actions work (add/edit/delete/update/cancel).
- Invalid CSRF request is rejected.

## Core Flows
- Patient registration -> login works.
- Patient can book appointment.
- Doctor can view appointments and update status.
- Doctor can add EMR.
- Admin can manage doctors/patients/appointments.

## Print/PDF
- View Appointment: Print works.
- View Appointment: Download PDF works.
- Print output is one page and styled correctly.

## Data Validation
- Search by ID/Name works:
  - Doctor ID format `DR-0001`
  - Patient ID format `PT-0001`
  - Appointment ID format `APT-0001`

## Operational
- Error logs are enabled and writable.
- Backups are configured.
- Timezone is correct on server.

