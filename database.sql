-- Clinic Management System Database

CREATE DATABASE IF NOT EXISTS clinic_system;
USE clinic_system;

-- Drop existing tables (if any)
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS imaging_studies;
DROP TABLE IF EXISTS imaging_results;
DROP TABLE IF EXISTS medical_records;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctor_schedules;
DROP TABLE IF EXISTS login_attempts;
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS users;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','doctor','patient') DEFAULT 'patient',
    status ENUM('active','inactive') DEFAULT 'active',
    specialization VARCHAR(100),
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE INDEX idx_users_role_status_created ON users(role, status, created_at);
CREATE INDEX idx_users_phone ON users(phone);

-- Appointments Table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
    reason_for_visit VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_patient_doctor (patient_id, doctor_id),
    INDEX idx_date (appointment_date),
    INDEX idx_doctor_date_time (doctor_id, appointment_date, appointment_time),
    INDEX idx_patient_date_status (patient_id, appointment_date, status)
);

-- Medical Records (EMR) Table
CREATE TABLE medical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    diagnosis TEXT,
    prescription TEXT,
    notes TEXT,
    treatment_plan TEXT,
    next_visit_date DATE,
    attachment VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY uq_medical_record_appointment (appointment_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id)
);

-- Imaging Results Table (X-ray, CT Scan, Echo, etc.)
CREATE TABLE imaging_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medical_record_id INT NULL,
    appointment_id INT NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    modality ENUM('X-RAY','CT','ECHO','ULTRASOUND','MRI','OTHER') DEFAULT 'OTHER',
    title VARCHAR(150) NOT NULL,
    findings TEXT,
    file_path VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size INT NOT NULL DEFAULT 0,
    mime_type VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medical_record_id) REFERENCES medical_records(id) ON DELETE SET NULL,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_imaging_medical_record (medical_record_id),
    INDEX idx_imaging_appointment (appointment_id),
    INDEX idx_imaging_patient (patient_id),
    INDEX idx_imaging_doctor (doctor_id),
    INDEX idx_imaging_created_at (created_at)
);

-- Synced Imaging Studies from PACS/Orthanc
CREATE TABLE imaging_studies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    study_instance_uid VARCHAR(128) NOT NULL UNIQUE,
    orthanc_study_id VARCHAR(64),
    patient_id INT NULL,
    appointment_id INT NULL,
    medical_record_id INT NULL,
    doctor_id INT NULL,
    modality VARCHAR(32),
    study_date DATE NULL,
    description VARCHAR(255),
    preview_url VARCHAR(255),
    dicomweb_url VARCHAR(255),
    status ENUM('new','linked') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
    FOREIGN KEY (medical_record_id) REFERENCES medical_records(id) ON DELETE SET NULL,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_study_status (status),
    INDEX idx_study_patient (patient_id),
    INDEX idx_study_appointment (appointment_id)
);

-- Enforce valid DICOM StudyInstanceUID format at DB level
-- Rule: digits with dot separators only, and max length 64.
DROP TRIGGER IF EXISTS bi_imaging_studies_validate_uid;
DROP TRIGGER IF EXISTS bu_imaging_studies_validate_uid;

DELIMITER $$
CREATE TRIGGER bi_imaging_studies_validate_uid
BEFORE INSERT ON imaging_studies
FOR EACH ROW
BEGIN
    SET NEW.study_instance_uid = TRIM(NEW.study_instance_uid);
    IF NEW.study_instance_uid IS NULL
       OR NEW.study_instance_uid = ''
       OR CHAR_LENGTH(NEW.study_instance_uid) > 64
       OR NEW.study_instance_uid NOT REGEXP '^[0-9]+(\\.[0-9]+)*$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid study_instance_uid format.';
    END IF;
END$$

CREATE TRIGGER bu_imaging_studies_validate_uid
BEFORE UPDATE ON imaging_studies
FOR EACH ROW
BEGIN
    SET NEW.study_instance_uid = TRIM(NEW.study_instance_uid);
    IF NEW.study_instance_uid IS NULL
       OR NEW.study_instance_uid = ''
       OR CHAR_LENGTH(NEW.study_instance_uid) > 64
       OR NEW.study_instance_uid NOT REGEXP '^[0-9]+(\\.[0-9]+)*$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid study_instance_uid format.';
    END IF;
END$$
DELIMITER ;

-- Doctor Schedule Table
CREATE TABLE doctor_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_schedule (doctor_id, day_of_week)
);

-- Notifications Table
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    appointment_id INT,
    message TEXT NOT NULL,
    notification_type ENUM('sms','email','in_app') DEFAULT 'in_app',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
    INDEX idx_notifications_user_read (user_id, is_read, created_at)
);

-- Login Attempt Rate-Limit Table
CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    email VARCHAR(100) NOT NULL,
    failed_count INT NOT NULL DEFAULT 0,
    last_failed_at TIMESTAMP NULL DEFAULT NULL,
    locked_until DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_login_attempt (ip_address, email),
    INDEX idx_login_locked_until (locked_until)
);

-- Audit Log Table
CREATE TABLE audit_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    role VARCHAR(20) NULL,
    action VARCHAR(80) NOT NULL,
    target_type VARCHAR(50) NULL,
    target_id INT NULL,
    status ENUM('success','failed','blocked','info') DEFAULT 'info',
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    request_url VARCHAR(255) NULL,
    meta_json TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_audit_created (created_at),
    INDEX idx_audit_action (action),
    INDEX idx_audit_user_action (user_id, action, created_at)
);

-- Insert Default Admin User (password: admin123)
INSERT INTO users (name, email, phone, password, role) VALUES 
('Admin User', 'admin@clinic.com', '0123456789', '$2y$10$4jKs53gfDZ0KVqTbUDRoPeDwotF9p1QRAB4kqR5iRHxBzv7HR5nHe', 'admin');

-- Insert Sample Doctor (password: doctor123)
INSERT INTO users (name, email, phone, password, role, specialization) VALUES 
('Dr. Sokchea', 'doctor@clinic.com', '0987654321', '$2y$10$G26IHmtgbvbdV6qCeo.fzu.i0s.GPtCKOV0FqH.gIEYWPd8gFRlCK', 'doctor', 'General Practice');

-- Insert Sample Patient (password: patient123)
INSERT INTO users (name, email, phone, password, role) VALUES 
('John Doe', 'patient@clinic.com', '0111111111', '$2y$10$iqKENskbXuKWRyk0Bp64SuCvy0esupb780ks6ae7vt.t6y.DCZfTG', 'patient');

-- Insert Doctor Schedule
INSERT INTO doctor_schedules (doctor_id, day_of_week, start_time, end_time) VALUES 
(2, 'Monday', '08:00:00', '17:00:00'),
(2, 'Tuesday', '08:00:00', '17:00:00'),
(2, 'Wednesday', '08:00:00', '17:00:00'),
(2, 'Thursday', '08:00:00', '17:00:00'),
(2, 'Friday', '08:00:00', '17:00:00');
