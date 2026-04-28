<?php
date_default_timezone_set('Asia/Dhaka');
session_start();
require_once 'db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $track = mysqli_real_escape_string($conn, $_POST['track']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;
    
    // Validation
    if (empty($full_name) || empty($email) || empty($password) || empty($role) || empty($track) || empty($start_date)) {
        $error = "Please fill in all required fields";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } elseif (!$terms_accepted) {
        $error = "You must accept the terms and conditions";
    } else {
        // Check if email already exists in registrations table
        $check_email = "SELECT id FROM registrations WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Email already registered";
        } else {
            // Hash password and insert user into registrations table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO registrations (full_name, email, phone, password, role, track, start_date, notes, terms_accepted) 
                            VALUES ('$full_name', '$email', '$phone', '$hashed_password', '$role', '$track', '$start_date', '$notes', $terms_accepted)";
            
            if (mysqli_query($conn, $insert_query)) {
                $success = "Registration successful! You can now <a href='lab_task_login.php'>login here</a>";
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - User Registration System</title>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="full_name" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Password * (min 6 characters)</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password *</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label>Role *</label>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="student" <?php echo (isset($_POST['role']) && $_POST['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
                    <option value="parent" <?php echo (isset($_POST['role']) && $_POST['role'] == 'parent') ? 'selected' : ''; ?>>Parent</option>
                    <option value="teacher" <?php echo (isset($_POST['role']) && $_POST['role'] == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                    <option value="professional" <?php echo (isset($_POST['role']) && $_POST['role'] == 'professional') ? 'selected' : ''; ?>>Professional</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Track *</label>
                <select name="track" required>
                    <option value="">Select Track</option>
                    <option value="creative-coding" <?php echo (isset($_POST['track']) && $_POST['track'] == 'creative-coding') ? 'selected' : ''; ?>>Creative Coding</option>
                    <option value="ui-ux" <?php echo (isset($_POST['track']) && $_POST['track'] == 'ui-ux') ? 'selected' : ''; ?>>UI/UX Design</option>
                    <option value="ai-fundamentals" <?php echo (isset($_POST['track']) && $_POST['track'] == 'ai-fundamentals') ? 'selected' : ''; ?>>AI Fundamentals</option>
                    <option value="foundations" <?php echo (isset($_POST['track']) && $_POST['track'] == 'foundations') ? 'selected' : ''; ?>>Foundations</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Start Date *</label>
                <input type="date" name="start_date" required value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Additional Notes</label>
                <textarea name="notes" placeholder="Any additional information..."><?php echo isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : ''; ?></textarea>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" name="terms_accepted" id="terms" required <?php echo isset($_POST['terms_accepted']) ? 'checked' : ''; ?>>
                <label for="terms">I accept the terms and conditions *</label>
            </div>
            
            <button type="submit">Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="lab_task_login.php">Login here</a>
        </div>
    </div>
</body>
</html>