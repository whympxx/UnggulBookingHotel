<?php
// hotel_data.php - Mock data to represent hotel details, replace with actual database queries.
$hotels = [
    [
        'name' => 'Hotel Trikora Beach',
        'location' => 'Bintan',
        'price' => 'Rp. 1.200.000/Night',
        'user' => 'Robert',
        'image' => 'Hotel trikora beach.jpg',
        'rating' => '4.7',
        'description' => 'Beachfront resort with stunning views'
    ],
    [
        'name' => 'Hotel Santika Prime',
        'location' => 'Harapan Indah Bekasi',
        'price' => 'Rp. 688.750/Night',
        'user' => 'Larry Naves',
        'image' => 'HotelSantika.jpg',
        'rating' => '4.5',
        'description' => 'Luxury hotel with modern amenities'
    ],
    [
        'name' => ' Hotel Royal Ambarukmo',
        'location' => 'Jogjakarta',
        'price' => 'Rp. 1.588.755/Night',
        'user' => 'Robert',
        'image' => 'royal-ambarukmo.jpg',
        'rating' => '4.8',
        'description' => 'Historic luxury hotel in Yogyakarta'
    ],
    [
        'name' => 'Hotel Novotel',
        'location' => 'Bandung',
        'price' => 'Rp. 653.801/Night',
        'user' => 'Jessica',
        'image' => 'HotelNovotel.jpg',
        'rating' => '4.6',
        'description' => 'Contemporary comfort in Bandung'
    ],
    [
        'name' => 'Hotel Fairfield',
        'location' => 'Bali',
        'price' => 'Rp. 1.131.350/Night',
        'user' => 'Jefri Nichol',
        'image' => 'fairfield.jpg',
        'rating' => '4.7',
        'description' => 'Beachfront paradise in Bali'
    ],
    [
        'name' => 'Hotel Kempinski',
        'location' => 'Jakarta Pusat',
        'price' => 'Rp. 688.750/Night',
        'user' => 'Marco Van Basten',
        'image' => 'HotelKempinski.jpg',
        'rating' => '4.9',
        'description' => 'Luxury 5-star hotel in central Jakarta'
    ],
    // More hotels can be added
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <div class="search-section">
            <div class="search-bar">
                <input type="text" placeholder="search by Hotel" class="search-input" id="searchInput">
                <select class="location-select" id="locationSelect">
                    <option value="all">All Location</option>
                    <option value="bekasi">Bekasi</option>
                    <option value="jogja">Jogjakarta</option>
                    <option value="bandung">Bandung</option>
                    <option value="bali">Bali</option>
                    <option value="jakarta">Jakarta</option>
                </select>
            </div>
        </div>
        <div class="section">
            <h2 class="section-title">Recommended Hotels</h2>
            <div class="hotel-cards-row" id="hotelCardsRow">
                <!-- Hotel cards akan dirender oleh JavaScript -->
            </div>
        </div>
        <div class="section">
            <h2 class="section-title">Popular Hotels</h2>
            <div class="populer-hotels-row">
                <!-- Contoh 2 hotel populer, bisa diubah ke dinamis jika ada data -->
                <div class="populer-hotel-card">
                    <div class="populer-hotel-img-wrap">
                        <img src="images/ritz-carlton.jpg" alt="The Ritz-Carlton Jakarta" class="populer-hotel-img">
                    </div>
                    <div class="populer-hotel-body">
                        <h3 class="populer-hotel-title">The Ritz-Carlton Jakarta</h3>
                        <p class="populer-hotel-desc">Located in the dynamic Sudirman Central Business District, The Ritz-Carlton Jakarta, Pacific Place features luxurious rooms, world-class amenities, and easy access to the city's top attractions. The hotel offers spacious rooms, a spa, and fine dining options for business and leisure travelers.</p>
                        <div class="populer-hotel-info">
                            <span><i class="fas fa-map-marker-alt"></i> Jakarta</span>
                            <span class="populer-hotel-price">Price: Rp. 8.000.000</span>
                        </div>
                        <div class="hotel-card-user">
                            <img src="images/Jessica.png" alt="Jessica" class="user-avatar">
                            <span>Jessica</span>
                        </div>
                        <div class="hotel-card-actions">
                            <a href="booking.php?name=The%20Ritz-Carlton%20Jakarta&location=Jakarta&price=Rp.%208.000.000&image=ritz-carlton.jpg&rating=4.9&description=Located%20in%20the%20dynamic%20Sudirman%20Central%20Business%20District%2C%20The%20Ritz-Carlton%20Jakarta%2C%20Pacific%20Place%20features%20luxurious%20rooms%2C%20world-class%20amenities%2C%20and%20easy%20access%20to%20the%20city%27s%20top%20attractions.%20The%20hotel%20offers%20spacious%20rooms%2C%20a%20spa%2C%20and%20fine%20dining%20options%20for%20business%20and%20leisure%20travelers." class="pesan-btn">Pesan Kamar</a>
                            <button class="add-to-cart-btn" data-hotel='{"name":"The Ritz-Carlton Jakarta","location":"Jakarta","price":"Rp. 8.000.000","image":"ritz-carlton.jpg","rating":"4.9","description":"Located in the dynamic Sudirman Central Business District"}'>
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="populer-hotel-card">
                    <div class="populer-hotel-img-wrap">
                        <img src="images/raffles.jpg" alt="Hotel Raffles" class="populer-hotel-img">
                    </div>
                    <div class="populer-hotel-body">
                        <h3 class="populer-hotel-title">Hotel Raffles</h3>
                        <p class="populer-hotel-desc">Hotel Raffles Jakarta is a luxurious hotel located in the heart of Jakarta, offering elegant rooms, exceptional service, and a range of premium facilities. Perfect for both business and leisure travelers seeking comfort and sophistication.</p>
                        <div class="populer-hotel-info">
                            <span><i class="fas fa-map-marker-alt"></i> Jakarta</span>
                            <span class="populer-hotel-price">Price: Rp. 4.700.000</span>
                        </div>
                        <div class="hotel-card-user">
                            <img src="images/jefrinichol.png" alt="Jefri Nichol" class="user-avatar">
                            <span>Jefri Nichol</span>
                        </div>
                        <div class="hotel-card-actions">
                            <a href="booking.php?name=Hotel%20Raffles&location=Jakarta&price=Rp.%204.700.000&image=raffles.jpg&rating=4.8&description=Hotel%20Raffles%20Jakarta%20is%20a%20luxurious%20hotel%20located%20in%20the%20heart%20of%20Jakarta%2C%20offering%20elegant%20rooms%2C%20exceptional%20service%2C%20and%20a%20range%20of%20premium%20facilities.%20Perfect%20for%20both%20business%20and%20leisure%20travelers%20seeking%20comfort%20and%20sophistication." class="pesan-btn">Pesan Kamar</a>
                            <button class="add-to-cart-btn" data-hotel='{"name":"Hotel Raffles","location":"Jakarta","price":"Rp. 4.700.000","image":"raffles.jpg","rating":"4.8","description":"Hotel Raffles Jakarta is a luxurious hotel"}'>
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
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
            <a href="cart.php" class="sidebar-nav-link"><i class="fas fa-cart-plus"></i> Keranjang Saya</a>
            <a href="Layanan.php" class="sidebar-nav-link"><i class="fas fa-bell-concierge"></i> Layanan</a>
            <a href="properties.php" class="sidebar-nav-link"><i class="fas fa-building"></i> Properties</a>
            <a href="agents.php" class="sidebar-nav-link"><i class="fas fa-headset"></i> Agent</a>
            <a href="contact_admin.php" class="sidebar-nav-link"><i class="fas fa-question-circle"></i> Contact Admin</a>
            <a href="settings.php" class="sidebar-nav-link"><i class="fas fa-screwdriver-wrench"></i> Setting</a>
        </nav>
        <div class="about-us-section">
            <h3 class="about-us-title">TENTANG KAMI</h3>
            <p class="about-us-text">Kami adalah layanan properti modern yang fokus pada penyewaan hotel—tempat di mana kenyamanan, kemudahan, dan gaya hidup bertemu. Lewat platform kami, kamu bisa menemukan berbagai pilihan hotel yang pas buat liburan santai, urusan kerja, atau sekadar short escape dari rutinitas.</p>
        </div>
        <button id="floatingMenuBtn" class="floating-menu-btn" aria-label="Open Menu" title="Open Menu (Ctrl + M)">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const floatingMenuBtn = document.getElementById('floatingMenuBtn');
            const closeSidebar = document.getElementById('closeSidebar');
            const mainBg = document.querySelector('.main-bg');
            const overlay = document.querySelector('.sidebar-overlay');
            const menuLinks = document.querySelectorAll('.sidebar-nav-link');
            const hotelCardsRow = document.getElementById('hotelCardsRow');

            // Fungsi render hotel
            function renderHotels(hotels) {
                hotelCardsRow.innerHTML = hotels.map(hotel => `
                    <div class="hotel-card" data-name="${hotel.name.toLowerCase()}" data-location="${hotel.location.toLowerCase()}">
                        <div class="hotel-card-img-wrap">
                            <img src="images/${hotel.image}" alt="${hotel.name}" class="hotel-card-img" onerror="this.onerror=null;this.src='images/logo.png';">
                            <div class="hotel-rating"><i class="fas fa-star"></i> ${hotel.rating}</div>
                        </div>
                        <div class="hotel-card-body">
                            <h3 class="hotel-card-title">${hotel.name}</h3>
                            <p class="hotel-card-location"><i class="fas fa-map-marker-alt"></i> ${hotel.location}</p>
                            <p class="hotel-card-price">${hotel.price}</p>
                            <div class="hotel-card-user">
                                <img src="images/${hotel.user.toLowerCase().replace(/\s/g, '')}.png" alt="${hotel.user}" class="user-avatar" onerror="this.onerror=null;this.src='images/logo.png';">
                                <span>${hotel.user}</span>
                            </div>
                            <div class="hotel-card-actions">
                                <a href="booking.php?name=${encodeURIComponent(hotel.name)}&location=${encodeURIComponent(hotel.location)}&price=${encodeURIComponent(hotel.price)}&image=${encodeURIComponent(hotel.image)}&rating=${encodeURIComponent(hotel.rating)}&description=${encodeURIComponent(hotel.description)}" class="pesan-btn">Pesan Kamar</a>
                                <button class="add-to-cart-btn" data-hotel='${JSON.stringify(hotel)}'><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </div>
                    </div>
                `).join('');
                // Re-attach event listener untuk tombol cart
                attachCartButtonListeners();
            }

            // Attach event listener ke tombol cart setelah render
            function attachCartButtonListeners() {
                const cartButtons = document.querySelectorAll('.add-to-cart-btn');
                cartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const hotelData = this.getAttribute('data-hotel');
                        let cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                        const newHotel = JSON.parse(hotelData);
                        // Cek duplikasi berdasarkan nama dan lokasi
                        const isExist = cartItems.some(item => item.name === newHotel.name && item.location === newHotel.location);
                        if (!isExist) {
                            cartItems.push(newHotel);
                            localStorage.setItem('cartItems', JSON.stringify(cartItems));
                        }
                        // Redirect ke cart
                        window.location.href = 'cart.php';
                    });
                });
            }

            // --- LIVE SEARCH/FILTER HOTEL ---
            const searchInput = document.getElementById('searchInput');
            const locationSelect = document.getElementById('locationSelect');

            function fetchHotels() {
                const searchValue = searchInput.value;
                const locationValue = locationSelect.value;
                fetch(`search_hotels.php?search=${encodeURIComponent(searchValue)}&location=${encodeURIComponent(locationValue)}`)
                    .then(response => response.json())
                    .then(data => {
                        renderHotels(data);
                    });
            }
            searchInput.addEventListener('input', fetchHotels);
            locationSelect.addEventListener('change', fetchHotels);

            // Panggil fetchHotels() saat halaman pertama kali load
            fetchHotels();

            // Add active state to current page link
            const currentPage = window.location.pathname.split('/').pop();
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === '' && href === '#')) {
                    link.classList.add('active');
                }
            });

            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-closed');
                mainBg.classList.toggle('main-expanded');
                overlay.classList.toggle('active');
                document.body.classList.toggle('sidebar-open');
                // Update aria-expanded state
                const isExpanded = !sidebar.classList.contains('sidebar-closed');
                sidebarToggle.setAttribute('aria-expanded', isExpanded);
                floatingMenuBtn.setAttribute('aria-expanded', isExpanded);
            }

            // Toggle sidebar with buttons
            sidebarToggle.addEventListener('click', toggleSidebar);
            floatingMenuBtn.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', toggleSidebar);

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Close sidebar with Escape key
                if (e.key === 'Escape' && !sidebar.classList.contains('sidebar-closed')) {
                    toggleSidebar();
                }
                // Toggle sidebar with Ctrl + M
                if (e.ctrlKey && e.key === 'm') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768 && 
                    !sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target) && 
                    !floatingMenuBtn.contains(e.target) &&
                    !sidebar.classList.contains('sidebar-closed')) {
                    toggleSidebar();
                }
            });

            // Add loading animation to menu items
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') !== '#') {
                        this.classList.add('loading');
                    }
                });
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('sidebar-closed');
                        mainBg.classList.remove('main-expanded');
                        overlay.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }
                }, 250);
            });

            // Show/hide floating button based on scroll position
            let lastScrollTop = 0;
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    floatingMenuBtn.classList.add('floating-menu-btn-hidden');
                } else {
                    // Scrolling up
                    floatingMenuBtn.classList.remove('floating-menu-btn-hidden');
                }
                lastScrollTop = scrollTop;
            });
        });
    </script>
</body>
</html>
