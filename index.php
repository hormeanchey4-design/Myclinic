<?php
include "includes/session_bootstrap.php";

// If already logged in, redirect to appropriate dashboard
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } elseif ($_SESSION['user']['role'] == 'doctor') {
        header("Location: doctor/dashboard.php");
    } else {
        header("Location: patient/dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Management System - Online Appointment & EMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Header/Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .btn-hero {
            padding: 12px 30px;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-card h5 {
            color: #333;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Demo Accounts Section */
        .demo-accounts {
            background: white;
            padding: 60px 0;
        }

        .demo-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            border-left: 5px solid var(--primary-color);
            margin-bottom: 20px;
        }

        .demo-card h5 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .demo-card p {
            margin: 8px 0;
            font-family: monospace;
            background: white;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .demo-card strong {
            color: #333;
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .feature-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-hospital-user"></i> Clinic System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#demo">Demo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="auth/register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <h1>🏥 Clinic Management System</h1>
                    <p>Online Appointment Booking, Queue Management & Electronic Medical Records (EMR)</p>
                    <p style="font-size: 14px; opacity: 0.9; margin-bottom: 30px;">Efficient healthcare delivery with modern technology</p>
                    <a href="auth/login.php" class="btn btn-light btn-hero"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="auth/register.php" class="btn btn-outline-light btn-hero"><i class="fas fa-user-plus"></i> Register</a>
                </div>
                <div class="col-md-6 text-center">
                    <i class="fas fa-hospital" style="font-size: 150px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="text-center mb-5" style="font-size: 36px; color: #333;">
                <strong>Key Features</strong>
            </h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5>Online Booking</h5>
                        <p>Book appointments with doctors from anywhere, anytime with ease</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h5>Doctor Management</h5>
                        <p>Manage doctors, schedules, and specializations efficiently</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <h5>EMR System</h5>
                        <p>Complete Electronic Medical Records for patient history tracking</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h5>Notifications</h5>
                        <p>Real-time SMS and Email notifications for appointments</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h5>Reports & Analytics</h5>
                        <p>Generate reports on appointments, doctors, and revenue</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h5>Security</h5>
                        <p>Secure login with encrypted passwords and role-based access</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Accounts Section -->
    <section class="demo-accounts" id="demo">
        <div class="container">
            <h2 class="text-center mb-5" style="font-size: 36px; color: #333;">
                <strong>Demo Accounts</strong>
            </h2>
            <p class="text-center text-muted mb-5">Use these test accounts to explore the system</p>
            <div class="row">
                <div class="col-md-4">
                    <div class="demo-card">
                        <h5><i class="fas fa-user-shield"></i> Admin Account</h5>
                        <p><strong>Email:</strong><br>admin@clinic.com</p>
                        <p><strong>Password:</strong><br>admin123</p>
                        <p style="font-size: 12px; color: #999;">Manage doctors, patients, and view reports</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="demo-card">
                        <h5><i class="fas fa-user-md"></i> Doctor Account</h5>
                        <p><strong>Email:</strong><br>doctor@clinic.com</p>
                        <p><strong>Password:</strong><br>doctor123</p>
                        <p style="font-size: 12px; color: #999;">View appointments and add medical records</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="demo-card">
                        <h5><i class="fas fa-user"></i> Patient Account</h5>
                        <p><strong>Email:</strong><br>patient@clinic.com</p>
                        <p><strong>Password:</strong><br>patient123</p>
                        <p style="font-size: 12px; color: #999;">Book appointments and view medical history</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Architecture Section -->
    <section class="features">
        <div class="container">
            <h2 class="text-center mb-5" style="font-size: 36px; color: #333;">
                <strong>System Architecture</strong>
            </h2>
            <div class="row">
                <div class="col-md-3 text-center">
                    <i class="fas fa-users" style="font-size: 48px; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <h5>Users</h5>
                    <p>Admin, Doctor, Patient</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-server" style="font-size: 48px; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <h5>Backend</h5>
                    <p>PHP + MySQL</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-database" style="font-size: 48px; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <h5>Database</h5>
                    <p>MySQL with InnoDB</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-lock" style="font-size: 48px; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <h5>Security</h5>
                    <p>Password Hashing & Sessions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <p>&copy; 2026 Clinic Management System. All rights reserved.</p>
            <p><small>Designed for healthcare providers in Cambodia and Southeast Asia</small></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
