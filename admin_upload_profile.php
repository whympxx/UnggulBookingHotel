<?php
header('Content-Type: application/json');
if (!isset($_FILES['profile_img']) || $_FILES['profile_img']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Tidak ada file yang diupload.']);
    exit;
}
$file = $_FILES['profile_img'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($ext, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Format file tidak didukung.']);
    exit;
}
if ($file['size'] > 2*1024*1024) { // 2MB max
    echo json_encode(['success' => false, 'error' => 'Ukuran file maksimal 2MB.']);
    exit;
}
$tmp = $file['tmp_name'];
$dest = __DIR__ . '/images/profil.jpg';
if (!move_uploaded_file($tmp, $dest)) {
    echo json_encode(['success' => false, 'error' => 'Gagal menyimpan file.']);
    exit;
}
// Optional: compress image, set permission, etc.
echo json_encode(['success' => true]); 