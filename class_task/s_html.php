<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { 
            font-family: Arial, sans-serif; margin: 50px; text-align: center; 
        }
        form { 
            max-width: 300px; margin: 0 auto; 
        }
        input { 
            display: block; width: 100%; margin: 10px 0; padding: 10px; 
        }
        button { 
            padding: 10px 20px; 
        }
    </style>
</head>
<body>
 
<h2>Login Page</h2>
 
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
 
    <button type="submit">Login</button>
</form>
 
</body>
</html>