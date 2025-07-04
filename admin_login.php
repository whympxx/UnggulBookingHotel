<?php
// admin_login.php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    // Koneksi ke database (ganti sesuai konfigurasi Anda)
    $conn = new mysqli('localhost', 'root', '', 'hotel_db');
    if ($conn->connect_error) {
        die('Koneksi gagal: ' . $conn->connect_error);
    }
    $stmt = $conn->prepare('SELECT id, password FROM admins WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            header('Location: admin_dashboard.php');
            exit();
        } else {
            $error = 'Password salah.';
        }
    } else {
        $error = 'Email tidak ditemukan.';
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hotel Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="login-modal">
        <button class="close-btn" onclick="window.location.href='user_selection.php'">&times;</button>
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?>
            <div style="background:#ffe082;color:#4b185a;padding:10px 15px;border-radius:8px;margin-bottom:1rem;text-align:center;font-weight:600;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="admin_login.php">
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
            <div class="form-options">
                <label style="color:#FFFFFFFF;"><input type="checkbox" name="remember"> Remember me</label>
                <a href="forget_password.php">Forget Password?</a>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="register-link">
            Don't have an account?
            <a href="admin_register.php" class="register-btn">Register</a>
        </div>
    </div>
</body>
</html> 