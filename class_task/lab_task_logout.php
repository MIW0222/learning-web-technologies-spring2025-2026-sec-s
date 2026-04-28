<?php
date_default_timezone_set('Asia/Dhaka');
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Clear any other cookies (optional)
if (isset($_COOKIE['last_login_time'])) {
    setcookie('last_login_time', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: lab_task_login.php");
exit();
?>