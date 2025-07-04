<?php
// Get hotel details from POST data
$hotel_name = isset($_POST['hotel_name']) ? $_POST['hotel_name'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$rating = isset($_POST['rating']) ? $_POST['rating'] : '';
$image = isset($_POST['image']) ? $_POST['image'] : '';

// Format price with Indonesian Rupiah format
function formatRupiah($price) {
    return 'Rp. ' . number_format($price, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hotel - <?php echo htmlspecialchars($hotel_name); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="booking.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="booking-container">
        <header class="booking-header">
            <a href="properties.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1>Booking Hotel</h1>
        </header>

        <div class="booking-content">
            <div class="hotel-details">
                <div class="hotel-image">
                    <?php if($image): ?>
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($hotel_name); ?>">
                    <?php endif; ?>
                    <div class="hotel-rating">
                        <i class="fas fa-star"></i> <?php echo htmlspecialchars($rating); ?>
                    </div>
                </div>
                <div class="hotel-info">
                    <h2><?php echo htmlspecialchars($hotel_name); ?></h2>
                    <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($location); ?></p>
                    <p class="price"><?php echo formatRupiah($price); ?>/Night</p>
                </div>
            </div>

            <form class="booking-form" action="process_booking.php" method="POST">
                <input type="hidden" name="hotel_name" value="<?php echo htmlspecialchars($hotel_name); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                <input type="hidden" name="image" value="<?php echo htmlspecialchars($image); ?>">
                
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="check_in">Tanggal Check-in</label>
                    <input type="date" id="check_in" name="check_in" required>
                </div>

                <div class="form-group">
                    <label for="check_out">Tanggal Check-out</label>
                    <input type="date" id="check_out" name="check_out" required>
                </div>

                <div class="form-group">
                    <label for="guests">Jumlah Tamu</label>
                    <select id="guests" name="guests" required>
                        <option value="1">1 Tamu</option>
                        <option value="2">2 Tamu</option>
                        <option value="3">3 Tamu</option>
                        <option value="4">4 Tamu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="room_type">Tipe Kamar</label>
                    <select id="room_type" name="room_type" required>
                        <option value="standard">Standard Room</option>
                        <option value="deluxe">Deluxe Room</option>
                        <option value="suite">Suite Room</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="special_requests">Permintaan Khusus</label>
                    <textarea id="special_requests" name="special_requests" rows="3"></textarea>
                </div>

                <div class="total-price">
                    <h3>Total Harga</h3>
                    <p id="total_price"><?php echo formatRupiah($price); ?></p>
                </div>

                <button type="submit" class="submit-booking">Konfirmasi Pemesanan</button>
            </form>
        </div>
    </div>

    <script>
        // Set minimum date for check-in to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('check_in').min = today;
        
        // Update check-out minimum date when check-in is selected
        document.getElementById('check_in').addEventListener('change', function() {
            document.getElementById('check_out').min = this.value;
        });

        // Calculate total price based on dates and room type
        document.addEventListener('DOMContentLoaded', function() {
            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');
            const guests = document.getElementById('guests');
            const roomType = document.getElementById('room_type');
            const totalPrice = document.getElementById('total_price');
            const basePrice = <?php echo $price; ?>;

            function calculateTotal() {
                if (checkIn.value && checkOut.value) {
                    const start = new Date(checkIn.value);
                    const end = new Date(checkOut.value);
                    const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                    
                    if (nights > 0) {
                        let price = basePrice * nights;
                        
                        // Adjust price based on room type
                        switch(roomType.value) {
                            case 'deluxe':
                                price *= 1.5;
                                break;
                            case 'suite':
                                price *= 2;
                                break;
                        }

                        // Format price in Indonesian Rupiah
                        totalPrice.textContent = 'Rp. ' + price.toLocaleString('id-ID');
                    }
                }
            }

            checkIn.addEventListener('change', calculateTotal);
            checkOut.addEventListener('change', calculateTotal);
            roomType.addEventListener('change', calculateTotal);
        });
    </script>
</body>
</html>