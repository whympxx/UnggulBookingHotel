<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="profile-container">
        <header class="profile-header">
            <a href="index.php" class="back-arrow"><i class="fas fa-arrow-left"></i> Kembali</a>
        </header>
        <div class="profile-content">
            <div class="profile-picture-section">
                <img src="images/profil.jpg" alt="Profile Picture" class="profile-picture" id="profile-picture-preview">
                <label for="profile-picture-upload" class="edit-profile-text">
                    <span>Edit Foto Profil</span>
                    <i class="fas fa-pencil-alt"></i>
                </label>
                <input type="file" id="profile-picture-upload" accept="image/*" style="display: none;">
            </div>
            <div class="profile-info-section">
                <div class="info-item">
                    <label for="username">Username</label>
                    <input type="text" id="username" value="Unggul Booking Hotel">
                </div>
                <div class="info-item">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="UnggulBooking.Hotel@example.com">
                </div>
                <div class="info-item">
                    <label for="phone">Nomor telepon</label>
                    <input type="text" id="phone" value="+62 812 3456 7890">
                </div>
            </div>
            <button class="logout-btn" onclick="location.reload()"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </div>
    <script>
        document.getElementById('profile-picture-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-picture-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html> 