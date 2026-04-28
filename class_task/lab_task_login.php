<?php
date_default_timezone_set('Asia/Dhaka');
session_start();
require_once 'db_connect.php'; 

// Get remembered email from cookie if exists
$remembered_email = isset($_COOKIE['remembered_email']) ? $_COOKIE['remembered_email'] : '';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    if (empty($email) || empty($password)) {
        $error = "Please enter email and password";
    } else {
        // Query user from registrations table
        $query = "SELECT id, full_name, email, password FROM registrations WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Set last login time cookie
                $current_time = date('Y-m-d H:i:s');
                setcookie('last_login_time', $current_time, time() + (86400 * 30), "/");
                
                // Set cookie to remember email if requested
                if ($remember) {
                    setcookie('remembered_email', $email, time() + (86400 * 30), "/"); // 30 days
                } else {
                    // Clear cookie if exists and remember is not checked
                    if (isset($_COOKIE['remembered_email'])) {
                        setcookie('remembered_email', '', time() - 3600, "/");
                    }
                }
                
                // Redirect to dashboard
                header("Location: lab_task_dashboard.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Email not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Registration System</title>
</head>
<body>
    <div class="container">
        <h2>Login to Your Account</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required value="<?php echo htmlspecialchars($remembered_email); ?>">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember my email</label>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>