<?php
// This file is for regular connection only - no table creation or data insertion
$host = "localhost";
$user = "root";
$password = "";
$dbName = "hospital_management_db";

// Connect directly to the database
$conn = mysqli_connect($host, $user, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>