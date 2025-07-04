<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="ganti_password.css">
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
            <div class="input-group">
                <label for="old-password">Masukkan Password Lama</label>
                <input type="password" id="old-password" class="password-input">
                <i class="fas fa-eye password-toggle"></i>
            </div>
            <div class="input-group">
                <label for="new-password">Password Baru</label>
                <input type="password" id="new-password" class="password-input">
                <i class="fas fa-eye password-toggle"></i>
            </div>
            <div class="input-group">
                <label for="confirm-password">Konfirmasi Password</label>
                <input type="password" id="confirm-password" class="password-input">
                <i class="fas fa-eye password-toggle"></i>
            </div>

            <button class="confirm-button">Konfirmasi</button>
        </div>
    </div>

    <script src="ganti_password.js"></script>
</body>
</html> 