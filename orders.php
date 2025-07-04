<?php
// orders.php
// Ambil data orders dari file JSON
$ordersFile = 'orders_data.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];

// Tambah logic edit order
$edit_data = null;
$edit_index = -1;
// Tambah logic delete order
if (isset($_GET['delete'])) {
    $delete_index = intval($_GET['delete']);
    if (isset($orders[$delete_index])) {
        array_splice($orders, $delete_index, 1);
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
        header('Location: orders.php');
        exit;
    }
}
if (isset($_GET['edit'])) {
    $edit_index = intval($_GET['edit']);
    if (isset($orders[$edit_index])) {
        $edit_data = $orders[$edit_index];
    }
}
// Simpan perubahan order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_index'])) {
    $edit_index = intval($_POST['edit_index']);
    if (isset($orders[$edit_index])) {
        $orders[$edit_index]['customer'] = trim($_POST['customer']);
        $orders[$edit_index]['hotel'] = trim($_POST['hotel']);
        $orders[$edit_index]['checkin'] = $_POST['checkin'];
        $orders[$edit_index]['checkout'] = $_POST['checkout'];
        $orders[$edit_index]['status'] = trim($_POST['status']);
        $orders[$edit_index]['total'] = trim($_POST['total']);
        $orders[$edit_index]['hotel_image'] = $_POST['hotel_image'];
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
        header('Location: orders.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Admin</title>
    <link rel="stylesheet" href="orders.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="orders-container">
        <header class="orders-header">
            <h2>Orders Management</h2>
            <a href="admin_dashboard.php" style="display:inline-block;margin-top:10px;padding:8px 18px;background:#1976d2;color:#fff;border-radius:6px;text-decoration:none;font-weight:500;font-family:'Poppins',sans-serif;font-size:1rem;transition:background 0.2s;">&larr; Kembali</a>
        </header>
        <main class="orders-main">
            <?php if ($edit_data): ?>
            <div id="edit-modal" style="background:rgba(0,0,0,0.25);position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:1000;display:flex;align-items:center;justify-content:center;" onclick="if(event.target===this)window.location='orders.php';">
                <form method="post" style="background:#fff;padding:32px 28px;border-radius:10px;min-width:340px;box-shadow:0 2px 16px rgba(0,0,0,0.12);display:flex;flex-direction:column;gap:14px;position:relative;" onclick="event.stopPropagation();">
                    <h3 style="margin:0 0 10px 0;">Edit Order</h3>
                    <input type="hidden" name="edit_index" value="<?php echo $edit_index; ?>">
                    <label>Customer:<input type="text" name="customer" value="<?php echo htmlspecialchars($edit_data['customer']); ?>" required></label>
                    <label>Hotel:<input type="text" name="hotel" value="<?php echo htmlspecialchars($edit_data['hotel']); ?>" required></label>
                    <label>Check-in:<input type="date" name="checkin" value="<?php echo htmlspecialchars($edit_data['checkin']); ?>" required></label>
                    <label>Check-out:<input type="date" name="checkout" value="<?php echo htmlspecialchars($edit_data['checkout']); ?>" required></label>
                    <label>Status:<input type="text" name="status" value="<?php echo htmlspecialchars($edit_data['status']); ?>" required></label>
                    <label>Total:<input type="text" name="total" value="<?php echo htmlspecialchars($edit_data['total']); ?>" required></label>
                    <label>Gambar Hotel:
                        <select name="hotel_image" required>
                            <option value="">- Pilih Gambar -</option>
                            <?php
                            $imageFiles = is_dir('images') ? array_filter(scandir('images'), function($f) {
                                return preg_match('/\.(jpg|jpeg|png)$/i', $f);
                            }) : [];
                            foreach ($imageFiles as $img) {
                                $selected = (isset($edit_data['hotel_image']) && $edit_data['hotel_image'] === $img) ? 'selected' : '';
                                echo "<option value=\"$img\" $selected>$img</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:10px;">
                        <button type="submit" class="edit-btn" style="min-width:90px;">Simpan</button>
                        <a href="orders.php" class="delete-btn" style="min-width:90px;text-align:center;">Batal</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Hotel</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Gambar Hotel</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $i => $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer']); ?></td>
                        <td><?php echo htmlspecialchars($order['hotel']); ?></td>
                        <td><?php echo $order['checkin']; ?></td>
                        <td><?php echo $order['checkout']; ?></td>
                        <td><?php echo $order['status']; ?></td>
                        <td><?php echo $order['total']; ?></td>
                        <td>
                            <?php
                            $hotelImage = '';
                            if (!empty($order['hotel_image'])) {
                                $hotelImage = $order['hotel_image'];
                            } else {
                                // Coba cari gambar yang cocok dengan nama hotel
                                $hotelName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $order['hotel']));
                                $imageFiles = is_dir('images') ? array_filter(scandir('images'), function($f) {
                                    return preg_match('/\.(jpg|jpeg|png)$/i', $f);
                                }) : [];
                                foreach ($imageFiles as $img) {
                                    $imgName = strtolower(pathinfo($img, PATHINFO_FILENAME));
                                    if (strpos($imgName, $hotelName) !== false) {
                                        $hotelImage = $img;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php if ($hotelImage): ?>
                                <img src="images/<?php echo htmlspecialchars($hotelImage); ?>" alt="Hotel Image" style="width:60px;height:40px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <span style="color:#aaa;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?edit=<?php echo $i; ?>" class="edit-btn"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?delete=<?php echo $i; ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus order ini?');"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html> 