-- Create the database
CREATE DATABASE IF NOT EXISTS emc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE emc_db;

-- Table for Users (Staff, Doctors, Nurses, Admins)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'nurse', 'receptionist') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Patients
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    national_id VARCHAR(20) UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    dob DATE,
    gender ENUM('male', 'female') NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Emergency Visits
CREATE TABLE IF NOT EXISTS visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    arrival_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('triage', 'waiting', 'in_treatment', 'discharged', 'admitted') DEFAULT 'triage',
    priority ENUM('critical', 'urgent', 'non-urgent') DEFAULT 'non-urgent',
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

-- Table for Triage Assessment
CREATE TABLE IF NOT EXISTS triage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_id INT NOT NULL,
    nurse_id INT NOT NULL,
    blood_pressure VARCHAR(20),
    heart_rate INT,
    temperature DECIMAL(4,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (visit_id) REFERENCES visits(id) ON DELETE CASCADE,
    FOREIGN KEY (nurse_id) REFERENCES users(id) ON DELETE RESTRICT
);

-- Table for Medical Records
CREATE TABLE IF NOT EXISTS medical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_id INT NOT NULL,
    doctor_id INT NOT NULL,
    diagnosis TEXT,
    treatment_plan TEXT,
    prescriptions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (visit_id) REFERENCES visits(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE RESTRICT
);

-- Insert a default admin user
INSERT IGNORE INTO users (username, password_hash, role, full_name) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'System Admin');
-- The default password is 'password'
