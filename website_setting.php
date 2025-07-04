<?php
// website_setting.php
// Halaman pengaturan website untuk admin

// Path file settings
$settings_file = 'website_settings.json';

// Fungsi untuk load settings dari file
function load_settings($file, $default) {
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        if (is_array($data)) return array_merge($default, $data);
    }
    return $default;
}
// Fungsi untuk simpan settings ke file
function save_settings($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}

// Default settings
$default_settings = [
    'site_title' => 'Unggul Booking Hotel',
    'welcome_message' => 'Selamat datang di Unggul Booking Hotel!',
    'primary_color' => '#2d89ef',
    'secondary_color' => '#f5f5f5',
    'logo' => 'images/logo.png',
    'favicon' => 'images/logo.png',
    'meta_description' => 'Website booking hotel terbaik dan terpercaya.',
    'meta_keywords' => 'hotel, booking, unggul, travel',
    'instagram' => '',
    'facebook' => '',
    'whatsapp' => '',
    'address' => '',
    'email' => '',
    'phone' => '',
    'footer_text' => '© 2024 Unggul Booking Hotel. All rights reserved.',
    'maintenance_mode' => false,
    'custom_css' => '',
    'custom_js' => '',
    'google_analytics' => '',
    'default_language' => 'id',
    'timezone' => 'Asia/Jakarta',
];

$settings = load_settings($settings_file, $default_settings);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $settings['site_title'] = $_POST['site_title'] ?? $settings['site_title'];
    $settings['welcome_message'] = $_POST['welcome_message'] ?? $settings['welcome_message'];
    $settings['primary_color'] = $_POST['primary_color'] ?? $settings['primary_color'];
    $settings['secondary_color'] = $_POST['secondary_color'] ?? $settings['secondary_color'];
    $settings['meta_description'] = $_POST['meta_description'] ?? $settings['meta_description'];
    $settings['meta_keywords'] = $_POST['meta_keywords'] ?? $settings['meta_keywords'];
    $settings['instagram'] = $_POST['instagram'] ?? $settings['instagram'];
    $settings['facebook'] = $_POST['facebook'] ?? $settings['facebook'];
    $settings['whatsapp'] = $_POST['whatsapp'] ?? $settings['whatsapp'];
    $settings['address'] = $_POST['address'] ?? $settings['address'];
    $settings['email'] = $_POST['email'] ?? $settings['email'];
    $settings['phone'] = $_POST['phone'] ?? $settings['phone'];
    $settings['footer_text'] = $_POST['footer_text'] ?? $settings['footer_text'];
    $settings['maintenance_mode'] = isset($_POST['maintenance_mode']) ? true : false;
    $settings['custom_css'] = $_POST['custom_css'] ?? $settings['custom_css'];
    $settings['custom_js'] = $_POST['custom_js'] ?? $settings['custom_js'];
    $settings['google_analytics'] = $_POST['google_analytics'] ?? $settings['google_analytics'];
    $settings['default_language'] = $_POST['default_language'] ?? $settings['default_language'];
    $settings['timezone'] = $_POST['timezone'] ?? $settings['timezone'];

    // Logo upload
    if (!empty($_FILES['logo']['name']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('images')) mkdir('images', 0777, true);
        $logo_ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['logo']['tmp_name']);
        finfo_close($finfo);
        $allowed_mimes = ['image/jpeg','image/png','image/gif','image/webp'];
        if (in_array($logo_ext, $allowed) && in_array($mime, $allowed_mimes) && $_FILES['logo']['size'] <= 2*1024*1024) {
            $logo_name = 'logo_' . time() . '.' . $logo_ext;
            $logo_path = 'images/' . $logo_name;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path)) {
                if (!empty($settings['logo']) && $settings['logo'] !== 'images/logo.png' && file_exists($settings['logo'])) {
                    @unlink($settings['logo']);
                }
                $settings['logo'] = $logo_path;
            } else {
                $error .= 'Gagal upload logo. ';
            }
        } else {
            $error .= 'Format/ukuran logo tidak valid. ';
        }
    }
    // Favicon upload
    if (!empty($_FILES['favicon']['name']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('images')) mkdir('images', 0777, true);
        $favicon_ext = strtolower(pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION));
        $allowed = ['ico','png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['favicon']['tmp_name']);
        finfo_close($finfo);
        $allowed_mimes = ['image/x-icon','image/png'];
        if (in_array($favicon_ext, $allowed) && in_array($mime, $allowed_mimes) && $_FILES['favicon']['size'] <= 512*1024) {
            $favicon_name = 'favicon_' . time() . '.' . $favicon_ext;
            $favicon_path = 'images/' . $favicon_name;
            if (move_uploaded_file($_FILES['favicon']['tmp_name'], $favicon_path)) {
                if (!empty($settings['favicon']) && $settings['favicon'] !== 'images/logo.png' && file_exists($settings['favicon'])) {
                    @unlink($settings['favicon']);
                }
                $settings['favicon'] = $favicon_path;
            } else {
                $error .= 'Gagal upload favicon. ';
            }
        } else {
            $error .= 'Format/ukuran favicon tidak valid. ';
        }
    }
    save_settings($settings_file, $settings);
    $success = empty($error);
}

// List bahasa dan timezone
$languages = [
    'id' => 'Bahasa Indonesia',
    'en' => 'English',
    'zh' => 'Chinese',
    'ar' => 'Arabic',
];
$timezones = [
    'Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura', 'Asia/Singapore', 'Asia/Bangkok', 'Asia/Tokyo', 'Europe/London', 'America/New_York'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Setting - Admin Panel</title>
    <link rel="stylesheet" href="website_setting.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/png" id="faviconTag" href="<?php echo $settings['favicon']; ?>">
    <?php if (!empty($settings['custom_css'])): ?>
    <style><?php echo $settings['custom_css']; ?></style>
    <?php endif; ?>
    <?php if (!empty($settings['google_analytics'])): ?>
    <?php echo $settings['google_analytics']; ?>
    <?php endif; ?>
</head>
<body>
    <a href="admin_dashboard.php" class="back-button"><span class="material-icons">arrow_back</span> Kembali ke Dashboard</a>
    <div class="setting-main-wrapper">
        <div class="setting-card">
            <h2 class="setting-title"><span class="material-icons icon-title">settings</span> Website Setting</h2>
            <?php if (!empty($success)): ?>
                <div class="success-message"><span class="material-icons success-icon">check_circle</span> Perubahan berhasil disimpan!</div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="error-message"><span class="material-icons" style="vertical-align:middle;color:#e53935;">error</span> <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" class="setting-form">
                <div class="setting-section">
                    <div class="section-title"><span class="material-icons">web</span> Website Info</div>
                    <hr class="section-divider">
                    <div class="form-group">
                        <label for="site_title">Site Title</label>
                        <input type="text" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="welcome_message">Welcome Message</label>
                        <input type="text" id="welcome_message" name="welcome_message" value="<?php echo htmlspecialchars($settings['welcome_message']); ?>">
                    </div>
                    <div class="form-group color-group">
                        <div>
                            <label for="primary_color">Primary Color</label>
                            <input type="color" id="primary_color" name="primary_color" value="<?php echo htmlspecialchars($settings['primary_color']); ?>">
                        </div>
                        <div>
                            <label for="secondary_color">Secondary Color</label>
                            <input type="color" id="secondary_color" name="secondary_color" value="<?php echo htmlspecialchars($settings['secondary_color']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" accept="image/*" onchange="previewLogo(event)">
                        <div class="logo-preview-wrapper">
                            <img id="logoPreview" src="<?php echo $settings['logo']; ?>" alt="Logo" class="logo-preview">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="favicon">Favicon</label>
                        <input type="file" id="favicon" name="favicon" accept="image/x-icon,image/png" onchange="previewFavicon(event)">
                        <div class="logo-preview-wrapper">
                            <img id="faviconPreview" src="<?php echo $settings['favicon']; ?>" alt="Favicon" class="logo-preview" style="height:32px;width:32px;">
                        </div>
                    </div>
                </div>
                <div class="setting-section">
                    <div class="section-title"><span class="material-icons">search</span> SEO</div>
                    <hr class="section-divider">
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" id="meta_description" name="meta_description" value="<?php echo htmlspecialchars($settings['meta_description']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($settings['meta_keywords']); ?>">
                    </div>
                </div>
                <div class="setting-section">
                    <div class="section-title"><span class="material-icons">share</span> Sosial Media</div>
                    <hr class="section-divider">
                    <div class="form-group">
                        <label>Social Media Links</label>
                        <input type="text" name="instagram" placeholder="Instagram URL" value="<?php echo htmlspecialchars($settings['instagram']); ?>" style="margin-bottom:6px;">
                        <input type="text" name="facebook" placeholder="Facebook URL" value="<?php echo htmlspecialchars($settings['facebook']); ?>" style="margin-bottom:6px;">
                        <input type="text" name="whatsapp" placeholder="WhatsApp Link" value="<?php echo htmlspecialchars($settings['whatsapp']); ?>">
                    </div>
                </div>
                <div class="setting-section">
                    <div class="section-title"><span class="material-icons">contact_mail</span> Kontak</div>
                    <hr class="section-divider">
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($settings['address']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($settings['phone']); ?>">
                    </div>
                </div>
                <div class="setting-section">
                    <div class="section-title"><span class="material-icons">tune</span> Lainnya</div>
                    <hr class="section-divider">
                    <div class="form-group">
                        <label for="footer_text">Footer Text</label>
                        <input type="text" id="footer_text" name="footer_text" value="<?php echo htmlspecialchars($settings['footer_text']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="maintenance_mode">Maintenance Mode</label>
                        <label class="switch">
                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" <?php if($settings['maintenance_mode']) echo 'checked'; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="custom_css">Custom CSS</label>
                        <textarea id="custom_css" name="custom_css" rows="2" placeholder="Tambahkan custom CSS..."><?php echo htmlspecialchars($settings['custom_css']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="custom_js">Custom JavaScript</label>
                        <textarea id="custom_js" name="custom_js" rows="2" placeholder="Tambahkan custom JS..."><?php echo htmlspecialchars($settings['custom_js']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="google_analytics">Google Analytics / Tracking Code</label>
                        <textarea id="google_analytics" name="google_analytics" rows="2" placeholder="Paste kode tracking di sini..."><?php echo htmlspecialchars($settings['google_analytics']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="default_language">Default Language</label>
                        <select id="default_language" name="default_language">
                            <?php foreach($languages as $key => $lang): ?>
                                <option value="<?php echo $key; ?>" <?php if($settings['default_language']==$key) echo 'selected'; ?>><?php echo $lang; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timezone">Timezone</label>
                        <select id="timezone" name="timezone">
                            <?php foreach($timezones as $tz): ?>
                                <option value="<?php echo $tz; ?>" <?php if($settings['timezone']==$tz) echo 'selected'; ?>><?php echo $tz; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-save"><span class="material-icons">save</span> Simpan Perubahan</button>
            </form>
        </div>
        <div class="preview-section">
            <h3>Preview Tampilan Index</h3>
            <div class="index-preview-modern" style="background:<?php echo $settings['secondary_color']; ?>;color:<?php echo $settings['primary_color']; ?>;">
                <img src="<?php echo $settings['logo']; ?>" alt="Logo" class="preview-logo">
                <h1><?php echo htmlspecialchars($settings['site_title']); ?></h1>
                <p><?php echo htmlspecialchars($settings['welcome_message']); ?></p>
                <a href="#" class="btn-book-now" style="background:<?php echo $settings['primary_color']; ?>;color:#fff;"><span class="material-icons" style="vertical-align:middle;">hotel</span> Book Now</a>
            </div>
        </div>
    </div>
    <script>
    // Live preview logo
    function previewLogo(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
                // Juga update preview di index
                const previewLogos = document.getElementsByClassName('preview-logo');
                for (let i = 0; i < previewLogos.length; i++) {
                    previewLogos[i].src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    }
    // Live preview favicon
    function previewFavicon(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('faviconPreview').src = e.target.result;
                document.getElementById('faviconTag').href = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
    <?php if (!empty($settings['custom_js'])): ?>
    <script><?php echo $settings['custom_js']; ?></script>
    <?php endif; ?>
</body>
</html> 