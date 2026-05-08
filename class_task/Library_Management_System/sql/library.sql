CREATE DATABASE IF NOT EXISTS university_library;
USE university_library;

CREATE TABLE books (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    availability ENUM('Available', 'Borrowed') DEFAULT 'Available'
);