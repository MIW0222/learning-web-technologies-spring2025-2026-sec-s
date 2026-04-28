<?php
date_default_timezone_set('Asia/Dhaka');
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: lab_task_login.php");
    exit();
}

// Get last login time from cookie
$display_last_login = isset($_COOKIE['last_login_time']) ? $_COOKIE['last_login_time'] : 'First time login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Registration System</title>
</head>
<body>
    <div class="navbar">
        <div class="logo">User Dashboard</div>
        <a href="lab_task_logout.php" class="logout-btn">Logout</a>
    </div>
    
    <div class="container">
        <div class="dashboard-card">
            <div class="welcome-message">
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <p>We're glad to see you again.</p>
            </div>
            
            <div class="info-section">
                <h3 style="margin-bottom: 20px; color: #333;">Account Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Last Login:</span>
                    <span class="info-value"><?php echo htmlspecialchars($display_last_login); ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>