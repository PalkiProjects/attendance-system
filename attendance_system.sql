CREATE DATABASE attendance_system;

USE attendance_system;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rfid_uid VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time_in TIME NOT NULL
);


INSERT INTO students (student_id, name, rfid_uid) VALUES
('101', 'Nitisha Nandal', 'A1B2C3D4'),
('102', 'Palki Tyagi', 'E5F6G7H8'),
('103', 'Gourav Nandal', 'I9J0K1L2');