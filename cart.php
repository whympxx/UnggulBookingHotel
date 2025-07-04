<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding items to cart via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' && isset($_POST['hotel'])) {
        $hotel = json_decode($_POST['hotel'], true);
        $_SESSION['cart'][] = $hotel;
        echo json_encode(['success' => true, 'message' => 'Hotel added to cart']);
        exit;
    }
    
    if ($_POST['action'] === 'remove' && isset($_POST['index'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            echo json_encode(['success' => true, 'message' => 'Hotel removed from cart']);
            exit;
        }
    }
    // Tambahkan endpoint untuk checkout satuan
    if ($_POST['action'] === 'checkout' && isset($_POST['hotel'])) {
        $_SESSION['checkout_hotel'] = json_decode($_POST['hotel'], true);
        echo json_encode(['success' => true]);
        exit;
    }
    // Tambahkan endpoint untuk checkout semua
    if ($_POST['action'] === 'checkout_all' && isset($_POST['hotels'])) {
        $_SESSION['checkout_hotels'] = json_decode($_POST['hotels'], true);
        echo json_encode(['success' => true]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Hotel Booking</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .cart-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .cart-item img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-item-details {
            flex: 1;
        }
        .cart-item-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }
        .cart-item-info {
            color: #666;
            margin-bottom: 5px;
        }
        .cart-item-price {
            font-size: 1.2em;
            color: #2ecc71;
            font-weight: bold;
            margin: 10px 0;
        }
        .cart-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .remove-btn:hover {
            background: #c0392b;
        }
        .checkout-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .checkout-btn:hover {
            background: #27ae60;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        .empty-cart i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
        }
        .cart-summary {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cart-summary h3 {
            margin-bottom: 15px;
            color: #333;
        }
        .checkout-all-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            margin-top: 15px;
            font-size: 1.1em;
        }
        .checkout-all-btn:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>
    <div class="main-bg">
        <header class="main-header">
            <div class="header-left">
                <button id="sidebarToggle" class="sidebar-toggle" aria-label="Toggle Menu" title="Toggle Menu (Ctrl + M)">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="company-name">Unggul Booking Hotel</span>
            </div>
            <div class="header-right">
                <a href="Register.php" class="register-btn">Registrasi</a>
                <a href="user_selection.php" class="login-btn">Login</a>
            </div>
        </header>

        <div class="cart-container">
            <h2>Keranjang Saya</h2>
            <div id="cartItems">
                <!-- Cart items will be dynamically added here -->
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Hotel Booking. All rights reserved.</p>
        </footer>
    </div>

    <div class="sidebar-overlay"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="images/logo.png" alt="Company Logo" class="sidebar-logo-img">
            <span class="sidebar-company-name">Menu</span>
            <button id="closeSidebar" class="close-sidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <a href="profile.php" class="sidebar-nav-link"><i class="fas fa-user"></i> Profile</a>
            <a href="index.php" class="sidebar-nav-link"><i class="fas fa-home"></i> Beranda</a>
            <a href="cart.php" class="sidebar-nav-link active"><i class="fas fa-cart-plus"></i> Keranjang Saya</a>
            <a href="layanan.php" class="sidebar-nav-link"><i class="fas fa-bell-concierge"></i> Layanan</a>
            <a href="properties.php" class="sidebar-nav-link"><i class="fas fa-building"></i> Properties</a>
            <a href="agents.php" class="sidebar-nav-link"><i class="fas fa-headset"></i> Agent</a>
            <a href="contact_admin.php" class="sidebar-nav-link"><i class="fas fa-question-circle"></i> Contact Admin</a>
            <a href="settings.php" class="sidebar-nav-link"><i class="fas fa-screwdriver-wrench"></i> Setting</a>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar functionality
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-closed');
                document.querySelector('.main-bg').classList.toggle('main-expanded');
                overlay.classList.toggle('active');
                document.body.classList.toggle('sidebar-open');
            }

            sidebarToggle.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Cart functionality
            const cartItemsContainer = document.getElementById('cartItems');
            
            function displayCartItems() {
                const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                
                if (cartItems.length > 0) {
                    let cartHTML = '';
                    cartItems.forEach((hotel, index) => {
                        cartHTML += `
                            <div class="cart-item">
                                <img src="images/${hotel.image}" alt="${hotel.name}">
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">${hotel.name}</h3>
                                    <p class="cart-item-info"><i class="fas fa-map-marker-alt"></i> ${hotel.location}</p>
                                    <p class="cart-item-info"><i class="fas fa-star"></i> ${hotel.rating}</p>
                                    <p class="cart-item-price">${hotel.price}</p>
                                    <div class="cart-actions">
                                        <button class="remove-btn" onclick="removeFromCart(${index})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                        <button class="checkout-btn" onclick="checkout(${index})">
                                            <i class="fas fa-shopping-cart"></i> Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Add cart summary
                    cartHTML += `
                        <div class="cart-summary">
                            <h3>Ringkasan Keranjang</h3>
                            <p>Total Hotel: ${cartItems.length}</p>
                            <button class="checkout-all-btn" onclick="checkoutAll()">
                                <i class="fas fa-shopping-cart"></i> Checkout Semua
                            </button>
                        </div>
                    `;

                    cartItemsContainer.innerHTML = cartHTML;
                } else {
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Keranjang Anda Kosong</h3>
                            <p>Silakan pilih hotel yang ingin Anda pesan</p>
                            <a href="index.php" class="checkout-btn" style="display: inline-block; margin-top: 20px;">
                                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div>
                    `;
                }
            }

            // Initialize cart display
            displayCartItems();

            // Make functions available globally
            window.removeFromCart = function(index) {
                let cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                cartItems.splice(index, 1);
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                displayCartItems();
            };

            window.checkout = function(index) {
                const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                const hotel = cartItems[index];
                fetch('cart.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'action=checkout&hotel=' + encodeURIComponent(JSON.stringify(hotel))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'payment.php';
                    } else {
                        alert('Gagal memproses checkout.');
                    }
                });
            };

            window.checkoutAll = function() {
                const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                fetch('cart.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'action=checkout_all&hotels=' + encodeURIComponent(JSON.stringify(cartItems))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'payment.php?all=1';
                    } else {
                        alert('Gagal memproses checkout semua.');
                    }
                });
            };
        });
    </script>
</body>
</html> 