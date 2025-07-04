<?php
// Register.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hotel Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="register-modal">
        <button class="close-btn" onclick="window.location.href='login.php'">&times;</button>
        <h2>Register</h2>
        <form method="post" action="Register.php">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="input-icon"><i class="fa fa-envelope"></i></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="input-icon"><i class="fa fa-lock"></i></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="input-icon"><i class="fa fa-lock"></i></span>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>
        <div class="login-link">
            Already have an account?
            <a href="login.php" class="login-btn">Login</a>
        </div>
    </div>
</body>
</html>