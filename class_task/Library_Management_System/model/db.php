<?php
function getDB() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'library_db';
    
    $conn = mysqli_connect($host, $user, $pass);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!mysqli_query($conn, $sql)) {
        die("Error creating database: " . mysqli_error($conn));
    }
    
    mysqli_select_db($conn, $dbname);
    
    $tableSql = "CREATE TABLE IF NOT EXISTS books (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        availability ENUM('Available', 'Borrowed') DEFAULT 'Available'
    )";
    
    if (!mysqli_query($conn, $tableSql)) {
        die("Error creating table: " . mysqli_error($conn));
    }
    
    return $conn;
}
?>