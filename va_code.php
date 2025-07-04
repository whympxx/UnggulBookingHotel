<?php
// Helper function for output sanitization
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Get payment method from URL parameter (lowercase, only allowed values)
$allowedMethods = ['bca', 'qris', 'cod'];
$paymentMethod = isset($_GET['payment']) && in_array(strtolower($_GET['payment']), $allowedMethods) ? strtolower($_GET['payment']) : 'bca';

// Get price from URL parameter and ensure it's a valid number
$price = isset($_GET['price']) ? filter_var($_GET['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0;
$price = is_numeric($price) ? floatval($price) : 0;

// Get hotel name from URL parameter
$hotelName = isset($_GET['hotel_name']) ? trim($_GET['hotel_name']) : 'Hotel Sejahtera';
$hotelName = $hotelName !== '' ? $hotelName : 'Hotel Sejahtera';
$hotelName = e($hotelName);

// Generate VA code based on payment method
function generateVACode($method, $price, $hotelName) {
    switch($method) {
        case 'bca':
            // Example: Generate a random 10-digit VA code
            return strval(rand(1000000000, 9999999999));
        case 'qris':
            return array(
                // Use the correct file name for QRIS logo
                'qris_image' => 'images/qris_logo.png',
                'merchant_name' => $hotelName,
                'amount' => 'Rp ' . number_format($price, 0, ',', '.'),
                'transaction_id' => 'TRX' . date('YmdHis') . rand(1000, 9999)
            );
        case 'cod':
            return array(
                'hotel_address' => 'Jl. Hotel Sejahtera No. 123, Jakarta',
                'agency_name' => 'Hotel Management Agency',
                'agency_contact' => '021-1234567',
                'pickup_time' => date('H:i', strtotime('-2 hours'))
            );
        default:
            return strval(rand(1000000000, 9999999999));
    }
}

$vaCode = generateVACode($paymentMethod, $price, $hotelName);
$paymentName = ucfirst($paymentMethod);

// Add error handling for QRIS
$qrisError = '';
if ($paymentMethod === 'qris' && $price <= 0) {
    $qrisError = 'Harga tidak valid. Silakan kembali ke halaman pembayaran.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Pembayaran</title>
    <link rel="stylesheet" href="va_code.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Kode Pembayaran</h2>
            <button type="button" class="close-button" onclick="handleClose()" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="payment-info">
            <div class="payment-method">
                <img src="images/<?php echo e($paymentMethod); ?>_logo.png" alt="Logo <?php echo e($paymentName); ?>">
                <h3><?php echo e($paymentName); ?></h3>
            </div>

            <div class="va-code-container">
                <?php if($paymentMethod === 'cod' && is_array($vaCode)): ?>
                <div class="cod-info">
                    <h4>Informasi Pengambilan Kunci Akses:</h4>
                    <p><strong>Alamat Hotel:</strong> <?php echo e($vaCode['hotel_address']); ?></p>
                    <p><strong>Agen Hotel:</strong> <?php echo e($vaCode['agency_name']); ?></p>
                    <p><strong>Kontak:</strong> <?php echo e($vaCode['agency_contact']); ?></p>
                    <p><strong>Waktu Pengambilan:</strong> 2 jam sebelum check-in (<?php echo e($vaCode['pickup_time']); ?>)</p>
                </div>
                <?php elseif($paymentMethod === 'qris' && is_array($vaCode)): ?>
                <h4>Pembayaran QRIS</h4>
                <?php if($qrisError): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo e($qrisError); ?></p>
                    <button class="back-button" onclick="window.location.href='payment.php'">Kembali ke Pembayaran</button>
                </div>
                <?php else: ?>
                <div class="qris-container">
                    <img src="<?php echo e($vaCode['qris_image']); ?>" alt="QRIS Barcode" class="qris-barcode">
                    <p class="merchant-info">
                        <strong>Merchant:</strong> <?php echo e($vaCode['merchant_name']); ?><br>
                        <strong>Jumlah:</strong> <?php echo e($vaCode['amount']); ?><br>
                        <strong>ID Transaksi:</strong> <?php echo e($vaCode['transaction_id']); ?>
                    </p>
                    <div class="qris-timer">
                        <i class="fas fa-clock"></i>
                        <span>Kode QRIS akan kadaluarsa dalam: <span id="countdown">15:00</span></span>
                    </div>
                </div>
                <?php endif; ?>
                <?php elseif(is_string($vaCode)): ?>
                <h4>Kode Virtual Account</h4>
                <div class="va-code">
                    <span id="va-code-value"><?php echo e($vaCode); ?></span>
                    <button class="copy-button" onclick="copyVACode()">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <?php endif; ?>
                <p class="expiry-info">
                    <?php 
                    if($paymentMethod === 'cod') {
                        echo 'Silakan ambil kunci akses sesuai waktu yang ditentukan';
                    } elseif($paymentMethod === 'qris' && !$qrisError) {
                        echo 'Silakan scan QRIS menggunakan aplikasi e-wallet Anda';
                    } else {
                        echo 'Kode ini akan kadaluarsa dalam 24 jam';
                    }
                    ?>
                </p>
            </div>

            <div class="instructions">
                <h4>Petunjuk Pembayaran:</h4>
                <ol>
                    <?php if($paymentMethod === 'cod'): ?>
                    <li>Kunjungi alamat hotel yang tertera di atas</li>
                    <li>Datang 2 jam sebelum waktu check-in</li>
                    <li>Lakukan pembayaran secara tunai</li>
                    <li>Dapatkan kunci akses dan bukti pembayaran dari petugas</li>
                    <?php elseif($paymentMethod === 'qris'): ?>
                    <li>Buka aplikasi e-wallet Anda (GoPay, OVO, DANA, LinkAja, dll)</li>
                    <li>Pilih menu "Scan QR" atau "Scan Barcode"</li>
                    <li>Scan barcode QRIS yang ditampilkan</li>
                    <li>Periksa detail transaksi dan konfirmasi pembayaran</li>
                    <?php else: ?>
                    <li>Salin kode Virtual Account di atas</li>
                    <li>Buka aplikasi <?php echo e($paymentName); ?> Anda</li>
                    <li>Pilih menu pembayaran</li>
                    <li>Masukkan kode Virtual Account yang telah disalin</li>
                    <li>Konfirmasi pembayaran</li>
                    <?php endif; ?>
                </ol>
            </div>

            <div class="payment-status">
                <div class="status-indicator">
                    <i class="fas fa-clock"></i>
                    <span>Menunggu Pembayaran</span>
                </div>
                <p class="status-info">Silakan selesaikan pembayaran Anda dalam waktu 24 jam</p>
            </div>
        </div>

        <button class="back-button" onclick="window.location.href='payment.php'">Kembali ke Halaman Pembayaran</button>
    </div>

    <script>
        function copyVACode() {
            const vaCode = document.getElementById('va-code-value');
            if (!vaCode) return;
            navigator.clipboard.writeText(vaCode.textContent).then(() => {
                alert('Kode berhasil disalin!');
            }).catch(err => {
                console.error('Gagal menyalin kode:', err);
            });
        }

        // Handle close button click
        function handleClose() {
            // Check if there's a payment in progress
            const hasActivePayment = document.querySelector('.payment-status .status-indicator i.fa-clock') !== null;
            if (hasActivePayment) {
                if (confirm('Apakah Anda yakin ingin menutup halaman? Pembayaran yang belum diselesaikan akan dibatalkan.')) {
                    window.location.href = 'payment.php';
                }
            } else {
                window.location.href = 'payment.php';
            }
        }

        // Handle browser back button
        window.addEventListener('popstate', function(event) {
            handleClose();
        });

        // Prevent accidental page refresh/close
        window.addEventListener('beforeunload', function(e) {
            const hasActivePayment = document.querySelector('.payment-status .status-indicator i.fa-clock') !== null;
            if (hasActivePayment) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // QRIS Countdown Timer
        function startQRISCountdown() {
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;

            let totalSeconds = 15 * 60;
            let interval = setInterval(function() {
                if (totalSeconds <= 0) {
                    countdownElement.textContent = 'Kadaluarsa';
                    countdownElement.style.color = 'red';
                    clearInterval(interval);
                    return;
                }
                totalSeconds--;
                let minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;
                countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        // Start countdown if QRIS payment is selected and no error
        if (document.querySelector('.qris-container')) {
            startQRISCountdown();
        }
    </script>
</body>
</html> 