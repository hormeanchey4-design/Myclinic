# 🏥 Clinic Management System + Online Booking + EMR Lite

A comprehensive clinic management system built with PHP and MySQL that includes online appointment booking, queue management, and Electronic Medical Records (EMR).

## 🎯 Features

✅ **Online Appointment Booking** - Patients can book appointments with doctors online
✅ **Queue Management** - Track appointments and manage patient queues
✅ **EMR System** - Complete Electronic Medical Records for patient history
✅ **Doctor Management** - Add, edit, and manage doctors
✅ **Patient Management** - Manage patient information and records
✅ **Admin Dashboard** - Complete admin panel for system management
✅ **Reports & Analytics** - Generate reports on appointments and revenue
✅ **Role-based Access** - Admin, Doctor, and Patient roles with specific permissions
✅ **Responsive Design** - Works on desktop, tablet, and mobile devices
✅ **Secure Authentication** - Password hashing and session management

## 📋 System Requirements

- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Web Server**: Apache (with mod_rewrite enabled)
- **Browser**: Modern browser with JavaScript enabled

## 🚀 Installation & Setup

### Step 1: Download XAMPP
Download and install [XAMPP](https://www.apachefriends.org/) for your operating system.

### Step 2: Copy Project Files
Copy the entire `clinic_system` folder to your XAMPP htdocs directory:
```
C:\xampp\htdocs\projcet2026\clinic_system\
```

### Step 3: Create Database
1. Start XAMPP (Apache and MySQL)
2. Open your browser and go to: `http://localhost/phpmyadmin`
3. Open the SQL tab and execute the contents of `database.sql`:
   - Copy all SQL queries from `clinic_system/database.sql`
   - Paste in phpMyAdmin SQL tab and execute

Or directly run:
```
mysql -u root -p < database.sql
```

### Step 4: Access the System
Open your browser and navigate to:
```
http://localhost/projcet2026/clinic_system/
```

## 🌐 Production Deployment

Before hosting online, review:
- `DEPLOYMENT_CHECKLIST.md`
- `.env.example`
- `APACHE_VHOST_SAMPLE.md`
- `MYSQL_PRODUCTION_SETUP.md`
- `PRELAUNCH_FINAL_CHECKLIST.md`

Set these environment variables in production:
- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`
- `APP_BASE_URL` (example: `https://your-domain.com/clinic_system/`)

## 👤 Demo Accounts

### Admin Account
- **Email**: admin@clinic.com
- **Password**: admin123
- **Access**: Full system control, manage doctors/patients, view reports

### Doctor Account
- **Email**: doctor@clinic.com
- **Password**: doctor123
- **Access**: View appointments, add medical records, manage patients

### Patient Account
- **Email**: patient@clinic.com
- **Password**: patient123
- **Access**: Book appointments, view history, manage profile

## 📁 Project Structure

```
clinic_system/
│
├── index.php                 # Home page
├── config/
│   └── db.php               # Database configuration
├── auth/
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   └── logout.php           # Logout handler
├── admin/
│   ├── dashboard.php        # Admin dashboard
│   ├── manage_doctors.php   # Manage doctors
│   ├── manage_patients.php  # Manage patients
│   ├── manage_appointments.php # Manage appointments
│   ├── reports.php          # Reports & analytics
│   └── view_appointment.php # View appointment details
├── doctor/
│   ├── dashboard.php        # Doctor dashboard
│   ├── appointments.php     # My appointments
│   ├── patients.php         # My patients
│   └── add_record.php       # Add EMR records
├── patient/
│   ├── dashboard.php        # Patient dashboard
│   ├── book_appointment.php # Book appointment
│   ├── my_appointments.php  # My appointments
│   ├── medical_history.php  # Medical history
│   └── view_appointment.php # View appointment
├── includes/
│   └── header.php           # Common header
├── assets/
│   ├── css/                 # CSS files
│   └── js/                  # JavaScript files
├── uploads/                 # File upload directory
├── database.sql             # Database schema
└── README.md                # This file
```

## 🗄 Database Structure

### Users Table
- id, name, email, phone, password, role, status, specialization, created_at

### Appointments Table
- id, patient_id, doctor_id, appointment_date, appointment_time, status, reason_for_visit

### Medical Records Table
- id, appointment_id, patient_id, doctor_id, diagnosis, prescription, notes, treatment_plan, next_visit_date

### Doctor Schedules Table
- id, doctor_id, day_of_week, start_time, end_time, is_available

### Notifications Table
- id, user_id, appointment_id, message, notification_type, is_read

## 🔐 Security Features

✅ Password hashing using bcrypt
✅ Session-based authentication
✅ Role-based access control
✅ SQL injection prevention (mysqli)
✅ XSS protection with htmlspecialchars()
✅ User input validation

## 📱 Responsive Design

The system is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

Built with Bootstrap 5 for consistent and modern design.

## 🎨 Customization

### Change Colors
Edit the `:root` variables in the header.php file:
```css
--primary-color: #667eea;
--secondary-color: #764ba2;
```

### Update Appointment Times
Modify the time slots in `patient/book_appointment.php`

### Add New Features
Follow the existing structure and add new files in appropriate folders

## 🐛 Troubleshooting

### Issue: Cannot connect to database
- Ensure MySQL is running in XAMPP
- Check database credentials in `config/db.php`
- Verify database name is `clinic_system`

### Issue: Blank page
- Check if all files have `<?php` tags
- Ensure database tables are created
- Check PHP error logs

### Issue: Login not working
- Clear browser cookies and cache
- Verify user exists in database
- Check password hash in database

## 📈 Future Enhancements

- SMS notifications integration
- Online payment system
- Prescription printing/PDF export
- Video consultation feature
- Mobile app (iOS/Android)
- Analytics dashboard improvements
- Multi-language support

## 💡 Tips for Deployment

1. Use HTTPS in production
2. Change default admin password immediately
3. Configure email for notifications
4. Set up regular backups
5. Use strong database passwords
6. Enable firewall rules
7. Keep PHP and MySQL updated

## 📞 Support

For issues or questions:
1. Check the project structure
2. Review database.sql for schema
3. Test with demo accounts first
4. Check PHP error logs

## 📄 License

This project is for educational and commercial use.

## 👨‍💻 Author

Clinic Management System - Built for Southeast Asian Healthcare Providers

---

**Last Updated**: February 2026

🏥 Thank you for using Clinic Management System!
