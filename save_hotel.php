<?php
// save_hotel.php
session_start();

// Set header untuk JSON response
header('Content-Type: application/json');

// Fungsi untuk validasi input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk upload gambar
function uploadImage($file) {
    $target_dir = "images/hotels/";
    
    // Buat direktori jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Validasi tipe file
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_extension, $allowed_types)) {
        return false;
    }
    
    // Validasi ukuran file (max 5MB)
    if ($file["size"] > 5 * 1024 * 1024) {
        return false;
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    }
    
    return false;
}

// Cek apakah request method adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validasi input
        $hotel_name = validateInput($_POST['hotel_name'] ?? '');
        $location = validateInput($_POST['location'] ?? '');
        $description = validateInput($_POST['description'] ?? '');
        $rating = validateInput($_POST['rating'] ?? '');
        $phone = validateInput($_POST['phone'] ?? '');
        
        // Validasi field yang required
        if (empty($hotel_name) || empty($location) || empty($description) || empty($rating)) {
            throw new Exception("Semua field wajib diisi");
        }
        
        // Validasi rating
        if (!in_array($rating, ['1', '2', '3', '4', '5'])) {
            throw new Exception("Rating tidak valid");
        }
        
        // Upload gambar
        $image_path = '';
        if (isset($_FILES['hotel_image']) && $_FILES['hotel_image']['error'] == 0) {
            $image_path = uploadImage($_FILES['hotel_image']);
            if (!$image_path) {
                throw new Exception("Gagal mengupload gambar. Pastikan format file adalah JPG, PNG, atau GIF dan ukuran maksimal 5MB.");
            }
        } else {
            throw new Exception("Gambar hotel wajib diupload");
        }
        
        // Simpan data hotel (dalam contoh ini menggunakan file JSON)
        $hotel_data = [
            'id' => uniqid(),
            'name' => $hotel_name,
            'location' => $location,
            'description' => $description,
            'rating' => (int)$rating,
            'phone' => $phone,
            'image' => $image_path,
            'created_at' => date('Y-m-d H:i:s'),
            'agent_id' => 'agent_' . uniqid(), // Simulasi agent ID
            'status' => 'active'
        ];
        
        // Baca data hotel yang sudah ada
        $hotels_file = 'hotels_data.json';
        $hotels = [];
        
        if (file_exists($hotels_file)) {
            $hotels = json_decode(file_get_contents($hotels_file), true) ?? [];
        }
        
        // Tambahkan hotel baru
        $hotels[] = $hotel_data;
        
        // Simpan ke file
        if (file_put_contents($hotels_file, json_encode($hotels, JSON_PRETTY_PRINT))) {
            // Response sukses
            echo json_encode([
                'success' => true,
                'message' => 'Hotel berhasil ditambahkan!',
                'data' => $hotel_data
            ]);
        } else {
            throw new Exception("Gagal menyimpan data hotel");
        }
        
    } catch (Exception $e) {
        // Response error
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    // Method tidak diizinkan
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?> 