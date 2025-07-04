<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css"> <!-- Specific styles for settings -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="main-bg">
        <header class="main-header">
            <div class="header-left">
                <a href="index.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="company-name">Setting</span>
            </div>
        </header>

        <div class="settings-container">
            <div class="settings-menu">
                <a href="account_security.php" class="menu-item">
                    <span>Akun & Keamanan</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="language_settings.php" class="menu-item">
                    <span>Bahasa/Language</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="profile.php" class="menu-item">
                    <span>Edit Profile</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="ganti_password.php" class="menu-item">
                    <span>Ganti Password</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <div class="settings-actions">
                <button class="action-btn">Ganti Akun</button>
                <button class="action-btn log-out">Log Out</button>
            </div>
        </div>
    </div>
</body>
</html> 