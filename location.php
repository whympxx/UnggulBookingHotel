<?php
// location.php
session_start();
// Ambil semua gambar hotel dari folder images
$hotel_images = [
    'HotelSantika.jpg',
    'royal-ambarukmo.jpg',
    'HotelNovotel.jpg',
    'fairfield.jpg',
    'HotelKempinski.jpg',
    'HotelContinental.jpg',
    'Hotel trikora beach.jpg',
    'spencer_green_hotel.jpg',
    'raffles.jpg',
    'ritz-carlton.jpg',
    'HotelSantika.jpg',
];
// Data default hotel lebih banyak
$default_hotels = [
    [
        'name' => 'Hotel Santika Prime',
        'location' => 'Harapan Indah Bekasi',
        'image' => 'HotelSantika.jpg',
    ],
    [
        'name' => 'Hotel Royal Ambarukmo',
        'location' => 'Jogjakarta',
        'image' => 'royal-ambarukmo.jpg',
    ],
    [
        'name' => 'Hotel Novotel',
        'location' => 'Bandung',
        'image' => 'HotelNovotel.jpg',
    ],
    [
        'name' => 'Hotel Fairfield',
        'location' => 'Bali',
        'image' => 'fairfield.jpg',
    ],
    [
        'name' => 'Hotel Kempinski',
        'location' => 'Jakarta Pusat',
        'image' => 'HotelKempinski.jpg',
    ],
    [
        'name' => 'Hotel Santika Prime',
        'location' => 'Harapan Indah Bekasi',
        'image' => 'HotelSantika.jpg',
    ],
    [
        'name' => 'Hotel Continental',
        'location' => 'Jakarta',
        'image' => 'HotelContinental.jpg',
    ],
    [
        'name' => 'Hotel Trikora Beach',
        'location' => 'Bintan',
        'image' => 'Hotel trikora beach.jpg',
    ],
    [
        'name' => 'Spencer Green Hotel',
        'location' => 'Batam',
        'image' => 'spencer_green_hotel.jpg',
    ],
    [
        'name' => 'Raffles Hotel',
        'location' => 'Jakarta',
        'image' => 'raffles.jpg',
    ],
    [
        'name' => 'Ritz Carlton',
        'location' => 'Jakarta',
        'image' => 'ritz-carlton.jpg',
    ],
];
// Load hotels dari session, jika belum ada pakai default
if (!isset($_SESSION['hotels'])) {
    $_SESSION['hotels'] = $default_hotels;
}
$hotels = $_SESSION['hotels'];
// Handle aksi tambah/edit/hapus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dengan cek isset terlebih dahulu agar aman
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $image = isset($_POST['image']) ? $_POST['image'] : (isset($hotel_images[0]) ? $hotel_images[0] : '');
    $edit_index = isset($_POST['edit_index']) ? intval($_POST['edit_index']) : -1;

    if ($name !== '' && $location !== '' && $image !== '') {
        $new_hotel = [
            'name'     => $name,
            'location' => $location,
            'image'    => $image,
        ];

        if ($edit_index >= 0 && isset($hotels[$edit_index])) {
            // Mode edit
            $hotels[$edit_index] = $new_hotel;
        } else {
            // Mode tambah
            $hotels[] = $new_hotel;
        }

        $_SESSION['hotels'] = $hotels;
        header('Location: location.php');
        exit;
    }
}

if (isset($_GET['delete'])) {
    $del = intval($_GET['delete']);
    if (isset($hotels[$del])) {
        array_splice($hotels, $del, 1);
        $_SESSION['hotels'] = $hotels;
        header('Location: location.php');
        exit;
    }
}
$edit_data = null;
$edit_index = -1;
if (isset($_GET['edit'])) {
    $edit_index = intval($_GET['edit']);
    if (isset($hotels[$edit_index])) {
        $edit_data = $hotels[$edit_index];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Locations - Unggul Booking Hotel</title>
    <link rel="stylesheet" href="location.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="location-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <span class="sidebar-title">Menu Admin</span>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="admin_dashboard.php" style="color:inherit;text-decoration:none;"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="active"><i class="fa fa-building"></i> Property Selection</li>
                    <li><i class="fa fa-cog"></i> Website Setting</li>
                    <li><i class="fa fa-shopping-cart"></i> Orders</li>
                    <li><i class="fa fa-user"></i> Agent</li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="main-header">
                <img src="images/logo.png" alt="Logo" class="logo">
                <span class="brand-title">Unggul Booking Hotel</span>
            </header>
            <section class="location-section">
                <div class="location-header">
                    <h2>View Locations</h2>
                    <button class="add-btn" onclick="showForm()"><i class="fa fa-plus"></i> Add New</button>
                </div>
                <div id="hotel-form-container" style="display:<?= $edit_data ? 'block' : 'none' ?>;margin-bottom:18px;">
                    <form method="post" class="hotel-form" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;background:#f0f6ff;padding:12px 16px;border-radius:6px;">
                        <input type="text" name="name" placeholder="Hotel Name" value="<?= isset($edit_data['name']) ? htmlspecialchars($edit_data['name']) : '' ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:160px;">
                        <input type="text" name="location" placeholder="Location" value="<?php echo isset($edit_data['location']) ? htmlspecialchars($edit_data['location']) : ''; ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:140px;">
                        <select name="image" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;">
                            <?php foreach ($hotel_images as $img): ?>
                                <option value="<?= $img ?>" <?= (isset($edit_data['image']) && $edit_data['image'] === $img) ? 'selected' : '' ?>><?= $img ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="edit_index" value="<?= $edit_index ?>">
                        <?php endif; ?>
                        <button type="submit" class="add-btn" style="margin:0;min-width:90px;"><i class="fa fa-save"></i> <?= $edit_data ? 'Update' : 'Add' ?></button>
                        <button type="button" onclick="hideForm()" class="delete-btn" style="margin:0;">Cancel</button>
                    </form>
                </div>
                <div class="table-container">
                    <table class="location-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Locations</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hotels as $i => $hotel): ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td>
                                    <?php 
                                    $img_path = 'images/' . $hotel['image']; 
                                    if (!file_exists($img_path) || !is_file($img_path)) {
                                        $img_path = 'images/default-hotel.jpg'; // fallback jika gambar tidak ada
                                    }
                                    ?>
                                    <img src="<?= $img_path ?>" alt="<?= htmlspecialchars($hotel['name']) ?>" class="hotel-photo">
                                </td>
                                <td><?= htmlspecialchars($hotel['name']) ?></td>
                                <td><?= htmlspecialchars($hotel['location']) ?></td>
                                <td>
                                    <a href="?edit=<?= $i ?>" class="edit-btn" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?= $i ?>" class="delete-btn" title="Delete" onclick="return confirm('Delete this hotel?')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
<script>
function showForm() {
    document.getElementById('hotel-form-container').style.display = 'block';
}
function hideForm() {
    window.location.href = 'location.php';
}
</script>
</html> 