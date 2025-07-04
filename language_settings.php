<!DOCTYPE html>
<?php
session_start();

// Function to set language
function setLanguage($lang) {
    $_SESSION['language'] = $lang;
    // Redirect to refresh the page with new language
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle language selection
if (isset($_GET['lang'])) {
    setLanguage($_GET['lang']);
}

// Handle reset language
if (isset($_GET['reset'])) {
    setLanguage('id');
}

// Default language if not set
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'id'; // Default to Indonesian
}

// Language translations
$translations = [
    'id' => [
        'title' => 'Pengaturan Bahasa',
        'main_language' => 'Bahasa Utama',
        'other_languages' => 'Bahasa Lainnya',
        'indonesian' => 'Bahasa Indonesia',
        'english' => 'Bahasa Inggris',
        'japanese' => 'Bahasa Jepang',
        'chinese' => 'Bahasa Mandarin',
        'reset_language' => 'Reset Bahasa'
    ],
    'en' => [
        'title' => 'Language Settings',
        'main_language' => 'Main Language',
        'other_languages' => 'Other Languages',
        'indonesian' => 'Indonesian',
        'english' => 'English',
        'japanese' => 'Japanese',
        'chinese' => 'Chinese',
        'reset_language' => 'Reset Bahasa'
    ],
    'ja' => [
        'title' => '言語設定',
        'main_language' => 'メイン言語',
        'other_languages' => 'その他の言語',
        'indonesian' => 'インドネシア語',
        'english' => '英語',
        'japanese' => '日本語',
        'chinese' => '中国語',
        'reset_language' => 'Reset Bahasa'
    ],
    'zh' => [
        'title' => '语言设置',
        'main_language' => '主要语言',
        'other_languages' => '其他语言',
        'indonesian' => '印尼语',
        'english' => '英语',
        'japanese' => '日语',
        'chinese' => '中文',
        'reset_language' => 'Reset Bahasa'
    ]
];

$currentLang = $_SESSION['language'];
$t = $translations[$currentLang];

// Get available languages excluding the current main language
$availableLanguages = array_diff(['id', 'en', 'ja', 'zh'], [$currentLang]);
?>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $t['title']; ?></title>
    <link rel="stylesheet" href="language_settings.css">
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
                <span class="company-name"><?php echo $t['title']; ?></span>
            </div>
        </header>

        <div class="settings-container">
            <div class="settings-menu">
                <div class="menu-group">
                    <div class="menu-category">
                        <span><?php echo $t['main_language']; ?></span>
                    </div>
                    <a href="?lang=<?php echo $currentLang; ?>" class="menu-item active">
                        <span><?php echo $t[$currentLang === 'id' ? 'indonesian' : ($currentLang === 'en' ? 'english' : ($currentLang === 'ja' ? 'japanese' : 'chinese'))]; ?></span>
                        <i class="fas fa-check"></i>
                    </a>
                </div>

                <div class="menu-group" style="margin-top: 12px;">
                    <div class="menu-category">
                        <span><?php echo $t['other_languages']; ?></span>
                    </div>
                    <?php foreach ($availableLanguages as $lang): ?>
                    <a href="?lang=<?php echo $lang; ?>" class="menu-item">
                        <span><?php echo $t[$lang === 'id' ? 'indonesian' : ($lang === 'en' ? 'english' : ($lang === 'ja' ? 'japanese' : 'chinese'))]; ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="menu-group" style="margin-top: 12px;">
                    <a href="?reset=1" class="menu-item reset-button">
                        <span><?php echo $t['reset_language']; ?></span>
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 