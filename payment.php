<?php
// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi format harga
function formatRupiah($angka) {
    return 'Rp. ' . number_format((int)preg_replace('/[^0-9]/', '', $angka), 0, ',', '.');
}

// Ambil data hotel dari session jika ada hasil checkout dari cart.php
if (isset($_SESSION['checkout_hotel'])) {
    $hotelData = $_SESSION['checkout_hotel'];
    $hotelName = isset($hotelData['name']) ? $hotelData['name'] : 'Hotel Raffles';
    $hotelLocation = isset($hotelData['location']) ? $hotelData['location'] : 'Ciputra World, Jl. Prof. DR. Satrio No.Kav 3 - 5, Kuningan, Karet Kuningan, Setiabudi, South Jakarta City, Jakarta 12840';
    $hotelImage = isset($hotelData['image']) ? $hotelData['image'] : 'hotel_raffles.jpg';
    $hotelRating = isset($hotelData['rating']) ? $hotelData['rating'] : '8.1 Luar Biasa';
    $hotelReviews = isset($hotelData['reviews']) ? $hotelData['reviews'] : '200 Ulasan';
    $normalPrice = isset($hotelData['normal_price']) ? $hotelData['normal_price'] : '4750000';
    $bookedPrice = isset($hotelData['price']) ? $hotelData['price'] : '4750000';
    $discount = isset($hotelData['discount']) ? $hotelData['discount'] : '0';
    $taxesFees = isset($hotelData['taxes_fees']) ? $hotelData['taxes_fees'] : '522500';
    $totalPrice = isset($hotelData['total_price']) ? $hotelData['total_price'] : $bookedPrice;
}
// Jika checkout semua, ambil hotel pertama sebagai contoh (atau bisa dikembangkan untuk menampilkan semua)
if (isset($_GET['all']) && $_GET['all'] == '1' && isset($_SESSION['checkout_hotels'])) {
    $hotelsData = $_SESSION['checkout_hotels'];
    $totalAll = 0;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informasi Pemesanan</title>
        <link rel="stylesheet" href="payment.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h2>Informasi Pemesanan Semua Hotel</h2>
            <a href="#" class="close-button" aria-label="Tutup">&times;</a>
        </div>
        <div class="hotel-list-summary">
            <?php foreach ($hotelsData as $hotelData):
                $hotelName = isset($hotelData['name']) ? $hotelData['name'] : '-';
                $hotelLocation = isset($hotelData['location']) ? $hotelData['location'] : '-';
                $hotelImage = isset($hotelData['image']) ? $hotelData['image'] : 'hotel_raffles.jpg';
                $hotelRating = isset($hotelData['rating']) ? $hotelData['rating'] : '-';
                $hotelPrice = isset($hotelData['price']) ? $hotelData['price'] : 0;
                $roomType = isset($hotelData['room_type']) ? $hotelData['room_type'] : '1 kamar x 1 malam';
                $roomCapacity = isset($hotelData['room_capacity']) ? $hotelData['room_capacity'] : 'Kapasitas kamar maks: 2 Dewasa, 2 Anak (0-8tahun)';
                $nights = isset($hotelData['nights']) ? $hotelData['nights'] : '1 Malam';
                $numericPrice = (int)preg_replace('/[^0-9]/', '', $hotelPrice);
                $totalAll += $numericPrice;
            ?>
            <div class="hotel-summary" style="margin-bottom: 20px;">
                <div class="hotel-image-wrapper">
                    <img src="images/<?php echo htmlspecialchars($hotelImage); ?>" alt="<?php echo htmlspecialchars($hotelName); ?>">
                </div>
                <div class="hotel-details-summary">
                    <h3><?php echo htmlspecialchars($hotelName); ?></h3>
                    <p class="address">Lokasi: <?php echo htmlspecialchars($hotelLocation); ?></p>
                    <p class="rating-text">Rating: <?php echo htmlspecialchars($hotelRating); ?></p>
                    <p class="cart-item-price">Harga: <?php echo formatRupiah($hotelPrice); ?></p>
                    <p class="room-type">Tipe Kamar: <?php echo htmlspecialchars($roomType); ?></p>
                    <p class="room-capacity">Kapasitas: <?php echo htmlspecialchars($roomCapacity); ?></p>
                    <p class="nights">Jumlah Malam: <?php echo htmlspecialchars($nights); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="payment-method">
            <h4>Pilih Metode Pembayaran:</h4>
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment_all" value="bca" checked>
                    <img src="images/bca_logo.png" alt="BCA">
                    <span>(Virtual Account)</span>
                </label>
                <label>
                    <input type="radio" name="payment_all" value="qris">
                    <img src="images/qris_logo.png" alt="QRIS">
                    <span>(Pembayaran Instan)</span>
                </label>
                <label>
                    <input type="radio" name="payment_all" value="cod">
                    <img src="images/cod_logo.png" alt="Bayar di Tempat">
                    <span>Bayar di Tempat</span>
                </label>
            </div>
        </div>
        <div class="price-details">
            <h4>Total Harga Semua Hotel</h4>
            <div class="total-price-summary">
                <h3><?php echo formatRupiah($totalAll); ?></h3>
            </div>
        </div>
        <button class="confirm-booking-button" onclick="proceedToPaymentAll()">Pesan Semua Sekarang</button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.close-button').addEventListener('click', function(e) {
                e.preventDefault();
                window.history.back();
            });
        });
        function proceedToPaymentAll() {
            const selectedPayment = document.querySelector('input[name="payment_all"]:checked').value;
            const totalPrice = '<?php echo $totalAll; ?>';
            if (!selectedPayment || !totalPrice || isNaN(totalPrice) || parseInt(totalPrice) <= 0) {
                alert('Data pembayaran tidak valid!');
                return;
            }
            window.location.href = `va_code.php?payment=${selectedPayment}&price=${totalPrice}&hotel_name=Checkout%20Semua`;
        }
    </script>
    </body>
    </html>
    <?php
    exit;
}
// Ambil data dari GET atau session
$checkInDate = isset($_GET['check_in']) ? $_GET['check_in'] : 'Sen, 02 Juni';
$checkOutDate = isset($_GET['check_out']) ? $_GET['check_out'] : 'Sel, 02 Juni';
$nights = isset($_GET['nights']) ? $_GET['nights'] : '1 Malam';
$roomType = isset($_GET['room_type']) ? $_GET['room_type'] : '1 kamar x 1 malam';
$roomCapacity = isset($_GET['room_capacity']) ? $_GET['room_capacity'] : 'Kapasitas kamar maks: 2 Dewasa, 2 Anak (0-8tahun)';
$guests = isset($_GET['guests']) ? $_GET['guests'] : 'Tamu: 3 Dewasa';
$hotelName = isset($_GET['hotel_name']) ? $_GET['hotel_name'] : (isset($hotelName) ? $hotelName : '');
$hotelPrice = isset($_GET['hotel_price']) ? $_GET['hotel_price'] : (isset($hotelPrice) ? $hotelPrice : '');
$hotelLocation = isset($_GET['hotel_location']) ? $_GET['hotel_location'] : (isset($hotelLocation) ? $hotelLocation : '');
$hotelImage = isset($_GET['hotel_image']) ? $_GET['hotel_image'] : (isset($hotelImage) ? $hotelImage : '');
$hotelRating = isset($_GET['hotel_rating']) ? $_GET['hotel_rating'] : (isset($hotelRating) ? $hotelRating : '');
$hotelReviews = isset($_GET['hotel_reviews']) ? $_GET['hotel_reviews'] : (isset($hotelReviews) ? $hotelReviews : '');
$normalPrice = isset($_GET['normal_price']) ? $_GET['normal_price'] : (isset($normalPrice) ? $normalPrice : '');
$bookedPrice = isset($_GET['booked_price']) ? $_GET['booked_price'] : (isset($bookedPrice) ? $bookedPrice : '');
$discount = isset($_GET['discount']) ? $_GET['discount'] : (isset($discount) ? $discount : '');
$taxesFees = isset($_GET['taxes_fees']) ? $_GET['taxes_fees'] : (isset($taxesFees) ? $taxesFees : '');
$totalPrice = isset($_GET['total_price']) ? $_GET['total_price'] : (isset($totalPrice) ? $totalPrice : '');
$nights = isset($_GET['nights']) ? $_GET['nights'] : (isset($nights) ? $nights : '');
$roomType = isset($_GET['room_type']) ? $_GET['room_type'] : (isset($roomType) ? $roomType : '');
$guests = isset($_GET['guests']) ? $_GET['guests'] : (isset($guests) ? $guests : '');
$name = isset($_GET['name']) ? $_GET['name'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$specialRequests = isset($_GET['special_requests']) ? $_GET['special_requests'] : '';
// Validasi data penting sebelum render halaman
if (empty($hotelName) || empty($hotelPrice) || empty($hotelLocation) || empty($hotelImage)) {
    echo '<script>alert("Data hotel tidak lengkap. Silakan ulangi proses pemesanan."); window.history.back();</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pemesanan</title>
    <link rel="stylesheet" href="payment.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Informasi Pemesanan</h2>
            <a href="#" class="close-button" aria-label="Tutup">&times;</a>
        </div>
        <div class="date-info">
            <div class="date-item">
                <span class="day"><?php echo htmlspecialchars($checkInDate); ?></span>
                <span class="label">Check-in</span>
            </div>
            <i class="fas fa-arrow-right"></i>
            <div class="date-item">
                <span class="day"><?php echo htmlspecialchars($checkOutDate); ?></span>
                <span class="label">Check-out</span>
            </div>
            <div class="date-item">
                <span class="night"><?php echo htmlspecialchars($nights); ?></span>
            </div>
        </div>
        <div class="hotel-summary">
            <div class="hotel-image-wrapper">
                <img src="images/<?php echo htmlspecialchars($hotelImage); ?>" alt="<?php echo htmlspecialchars($hotelName); ?>">
                <div class="not-refundable">
                    <input type="checkbox" id="refundable" checked disabled>
                    <label for="refundable">Tidak bisa di refund</label>
                </div>
            </div>
            <div class="hotel-details-summary">
                <h3><?php echo htmlspecialchars($hotelName); ?></h3>
                <div class="stars">
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="rating-text"><?php echo htmlspecialchars($hotelRating); ?> <span><?php echo htmlspecialchars($hotelReviews); ?></span></p>
                <p class="address"><?php echo htmlspecialchars($hotelLocation); ?></p>
            </div>
        </div>
        <div class="room-summary">
            <h4><?php echo htmlspecialchars($roomType); ?></h4>
            <p class="capacity"><?php echo htmlspecialchars($roomCapacity); ?></p>
            <p class="guests"><i class="fas fa-users"></i> <?php echo htmlspecialchars($guests); ?></p>
            <div class="amenities">
                <p><i class="fas fa-clock"></i> Check-in 24 jam</p>
                <p><i class="fas fa-bed"></i> 2 Kasur Single</p>
                <p><i class="fas fa-check-circle"></i> Pesan dan bayar sekarang</p>
                <p class="availability"><i class="fas fa-exclamation-circle"></i> Tinggal 4 kamar yang tersedia.</p>
                <p><i class="fas fa-car"></i> Parkir</p>
            </div>
        </div>
        <div class="payment-method">
            <h4>Metode pembayaran:</h4>
            <p class="privacy-text">Beritahu kami metode pembayaran sepenuhnya terenkripsi dan menjamin melindungi privasi anda.</p>
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment" value="bca" checked>
                    <img src="images/bca_logo.png" alt="BCA">
                    <span>(Virtual Account)</span>
                </label>
                <label>
                    <input type="radio" name="payment" value="qris">
                    <img src="images/qris_logo.png" alt="QRIS">
                    <span>(Pembayaran Instan)</span>
                </label>
                <label>
                    <input type="radio" name="payment" value="cod">
                    <img src="images/cod_logo.png" alt="Bayar di Tempat">
                    <span>Bayar di Tempat</span>
                </label>
            </div>
            <p class="terms-text">Dengan melanjutkan pesanan ini, anda menyetujui <a href="#">ketentuan</a> dan <a href="#">kebijakan Privasi</a> Unggal Booking Hotel.</p>
        </div>
        <div class="price-details">
            <h4>Detail Harga</h4>
            <div class="price-item">
                <span>Harga kamar normal (1 kamar x 1 malam)</span>
                <span><?php echo formatRupiah($normalPrice); ?></span>
            </div>
            <div class="price-item">
                <span>Harga kamar yang di pesan (1 kamar x 1 malam)</span>
                <span><?php echo formatRupiah($bookedPrice); ?></span>
            </div>
            <div class="price-item">
                <span>Potongan harga dari diskon</span>
                <span><?php echo formatRupiah($discount); ?></span>
            </div>
            <div class="price-item">
                <span>Pajak dan biaya lainnya</span>
                <span><?php echo formatRupiah($taxesFees); ?></span>
            </div>
            <div class="total-price-summary">
                <h3>Total Harga <i class="fas fa-info-circle"></i></h3>
                <h3><?php echo formatRupiah($totalPrice); ?></h3>
            </div>
            <p class="include-tax">Termasuk di dalam harga: pajak 10%, Biaya layanan 1%</p>
        </div>
        <?php if ($name || $email || $phone || $specialRequests): ?>
        <div class="booking-info">
            <h4>Data Pemesan</h4>
            <?php if ($name): ?><p><strong>Nama:</strong> <?php echo htmlspecialchars($name); ?></p><?php endif; ?>
            <?php if ($email): ?><p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p><?php endif; ?>
            <?php if ($phone): ?><p><strong>Telepon:</strong> <?php echo htmlspecialchars($phone); ?></p><?php endif; ?>
            <?php if ($specialRequests): ?><p><strong>Permintaan Khusus:</strong> <?php echo htmlspecialchars($specialRequests); ?></p><?php endif; ?>
        </div>
        <?php endif; ?>
        <button class="confirm-booking-button" onclick="proceedToPayment()">Pesan Sekarang</button>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.close-button').addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    });
    function proceedToPayment() {
        // Kirim data order ke PHP untuk disimpan
        const orderData = {
            customer: '<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Guest"; ?>',
            hotel: '<?php echo htmlspecialchars($hotelName); ?>',
            checkin: '<?php echo htmlspecialchars($checkInDate); ?>',
            checkout: '<?php echo htmlspecialchars($checkOutDate); ?>',
            status: 'Pending',
            total: '<?php echo preg_replace('/[^0-9]/', '', $totalPrice); ?>'
        };
        if (!orderData.hotel || !orderData.checkin || !orderData.checkout || !orderData.total || isNaN(orderData.total) || parseInt(orderData.total) <= 0) {
            alert('Data pemesanan tidak valid!');
            return;
        }
        fetch('save_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        }).then(response => response.json())
        .then(data => {
            if (data && data.success) {
                const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
                const totalPrice = '<?php echo preg_replace('/[^0-9]/', '', $totalPrice); ?>';
                const hotelName = '<?php echo htmlspecialchars($hotelName); ?>';
                window.location.href = `va_code.php?payment=${selectedPayment}&price=${totalPrice}&hotel_name=${encodeURIComponent(hotelName)}`;
            } else {
                alert('Gagal menyimpan pesanan. Silakan coba lagi.');
            }
        }).catch(() => {
            alert('Terjadi kesalahan saat menyimpan pesanan. Silakan cek koneksi internet Anda atau coba beberapa saat lagi.');
        });
    }
    </script>
</body>
</html> 