-- Create the database
CREATE DATABASE IF NOT EXISTS attendance_sys;

-- Use the created database
USE attendance_sys;

-- Create or update the student_details table
CREATE TABLE IF NOT EXISTS student_details (
  sid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  address TEXT,
  image BLOB,
  fathers_name VARCHAR(100) DEFAULT NULL,
  mothers_name VARCHAR(100) DEFAULT NULL,
  section VARCHAR(50) DEFAULT NULL,
  grade VARCHAR(50) DEFAULT NULL,
  gender VARCHAR(10) DEFAULT NULL,
  dob DATE NOT NULL,
  mobileno VARCHAR(15) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the students table
CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    qr_code VARCHAR(255) UNIQUE NOT NULL,
    section VARCHAR(50) DEFAULT NULL,
    grade VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the attendance table
CREATE TABLE IF NOT EXISTS attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE NOT NULL,
    status ENUM('Present', 'Absent') DEFAULT 'Present',
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Create the admin table
CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
