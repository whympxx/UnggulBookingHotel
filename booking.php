<?php
// Get hotel data from the URL parameters
$hotelName = isset($_GET['name']) ? $_GET['name'] : '';
$hotelLocation = isset($_GET['location']) ? $_GET['location'] : '';
$hotelPrice = isset($_GET['price']) ? $_GET['price'] : '';
$hotelImage = isset($_GET['image']) ? $_GET['image'] : '';
$hotelRating = isset($_GET['rating']) ? $_GET['rating'] : '';
$hotelDescription = isset($_GET['description']) ? $_GET['description'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hotel - <?php echo htmlspecialchars($hotelName); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="booking.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="booking-container">
        <header class="booking-header">
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1>Booking Hotel</h1>
        </header>

        <div class="booking-content">
            <div class="hotel-details">
                <div class="hotel-image">
                    <img src="images/<?php echo htmlspecialchars($hotelImage); ?>" alt="<?php echo htmlspecialchars($hotelName); ?>">
                    <div class="hotel-rating">
                        <i class="fas fa-star"></i> <?php echo htmlspecialchars($hotelRating); ?>
                    </div>
                </div>
                <div class="hotel-info">
                    <h2><?php echo htmlspecialchars($hotelName); ?></h2>
                    <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($hotelLocation); ?></p>
                    <p class="price"><?php echo htmlspecialchars($hotelPrice); ?></p>
                    <p class="description"><?php echo htmlspecialchars($hotelDescription); ?></p>
                </div>
            </div>

            <form class="booking-form" action="payment.php" method="GET">
                <input type="hidden" name="hotel_name" value="<?php echo htmlspecialchars($hotelName); ?>">
                <input type="hidden" name="hotel_price" value="<?php echo htmlspecialchars($hotelPrice); ?>">
                <input type="hidden" name="hotel_location" value="<?php echo htmlspecialchars($hotelLocation); ?>">
                <input type="hidden" name="hotel_image" value="<?php echo htmlspecialchars($hotelImage); ?>">
                <input type="hidden" name="hotel_rating" value="<?php echo htmlspecialchars($hotelRating); ?>">
                <input type="hidden" name="hotel_reviews" value="200 Ulasan">
                <input type="hidden" name="normal_price" id="normal-price-input" value="">
                <input type="hidden" name="booked_price" id="booked-price-input" value="">
                <input type="hidden" name="discount" value="Rp. -">
                <input type="hidden" name="taxes_fees" value="Rp. 522.500">
                <input type="hidden" name="total_price" id="total-price-input" value="">
                <input type="hidden" name="nights" id="nights-input" value="">
                
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
                    <label for="check-in">Check-in Date</label>
                    <input type="date" id="check-in" name="check_in" required>
                </div>

                <div class="form-group">
                    <label for="check-out">Check-out Date</label>
                    <input type="date" id="check-out" name="check_out" required>
                </div>

                <div class="form-group">
                    <label for="guests">Number of Guests</label>
                    <select id="guests" name="guests" required>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="room-type">Room Type</label>
                    <select id="room-type" name="room_type" required onchange="calculateTotal()">
                        <option value="standard">Standard Room</option>
                        <option value="deluxe">Deluxe Room</option>
                        <option value="suite">Suite Room</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="special-requests">Special Requests</label>
                    <textarea id="special-requests" name="special_requests" rows="3"></textarea>
                </div>

                <div class="total-price">
                    <h3>Total Harga: <span id="total-price">Rp 0</span></h3>
                </div>

                <button type="submit" class="submit-booking">Konfirmasi Booking</button>
            </form>
        </div>
    </div>

    <script>
        // Set minimum date for check-in to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('check-in').min = today;
        
        // Update check-out minimum date when check-in is selected
        document.getElementById('check-in').addEventListener('change', function() {
            document.getElementById('check-out').min = this.value;
            calculateTotal();
        });

        document.getElementById('check-out').addEventListener('change', calculateTotal);
        document.getElementById('guests').addEventListener('change', calculateTotal);

        function calculateTotal() {
            const basePrice = parseInt('<?php echo preg_replace("/[^0-9]/", "", $hotelPrice); ?>');
            const checkIn = new Date(document.getElementById('check-in').value);
            const checkOut = new Date(document.getElementById('check-out').value);
            const roomType = document.getElementById('room-type').value;
            
            // Calculate number of nights
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            
            // Room type multipliers
            const multipliers = {
                'standard': 1,
                'deluxe': 1.5,
                'suite': 2
            };
            
            // Calculate total price
            let total = basePrice * nights * multipliers[roomType];
            
            // Format price to Indonesian Rupiah
            const formattedPrice = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(total);
            
            document.getElementById('total-price').textContent = formattedPrice;

            // Update hidden input fields for payment.php
            document.getElementById('normal-price-input').value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(basePrice);
            document.getElementById('booked-price-input').value = formattedPrice;
            document.getElementById('total-price-input').value = formattedPrice;
            document.getElementById('nights-input').value = nights + ' Malam';
        }
    </script>
</body>
</html> 