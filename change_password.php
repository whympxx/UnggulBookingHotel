<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="change_password.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="main-bg">
        <header class="main-header">
            <div class="header-left">
                <a href="settings.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="company-name">Ganti Password</span>
            </div>
        </header>

        <div class="password-change-container">
            <form action="#" method="POST" class="password-change-form">
                <div class="input-group">
                    <label for="old-password">Masukan Password Lama</label>
                    <input type="password" id="old-password" name="old_password" required>
                    <span class="toggle-password"><i class="fas fa-eye"></i></span>
                </div>
                <div class="input-group">
                    <label for="new-password">Password Baru</label>
                    <input type="password" id="new-password" name="new_password" required>
                    <span class="toggle-password"><i class="fas fa-eye"></i></span>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Konfirmasi Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                    <span class="toggle-password"><i class="fas fa-eye"></i></span>
                </div>
                <button type="submit" class="konfirmasi-btn">Konfirmasi</button>
            </form>
        </div>
    </div>
    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', event => {
                const passwordInput = item.previousElementSibling;
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                item.querySelector('i').classList.toggle('fa-eye-slash');
                item.querySelector('i').classList.toggle('fa-eye');
            });
        });
    </script>
</body>
</html> 