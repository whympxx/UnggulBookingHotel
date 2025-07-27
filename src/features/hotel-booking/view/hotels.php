<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking - Unggul Booking Hotel</title>
    <link rel="stylesheet" href="/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="main-bg">
        <?php echo renderHeader(); ?>
        
        <div class="search-section">
            <div class="search-bar">
                <input type="text" placeholder="Search by Hotel" class="search-input" id="searchInput">
                <select class="location-select" id="locationSelect">
                    <option value="all">All Location</option>
                    <option value="bekasi">Bekasi</option>
                    <option value="jogja">Jogjakarta</option>
                    <option value="bandung">Bandung</option>
                    <option value="bali">Bali</option>
                    <option value="jakarta">Jakarta</option>
                    <option value="bintan">Bintan</option>
                </select>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Available Hotels</h2>
            <div class="hotel-cards-row" id="hotelCardsRow">
                <?php foreach ($hotels as $hotel): ?>
                    <div class="hotel-card" data-location="<?php echo strtolower($hotel['location']); ?>">
                        <div class="hotel-img-wrap">
                            <img src="/images/<?php echo htmlspecialchars($hotel['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($hotel['name']); ?>" 
                                 class="hotel-img">
                            <div class="hotel-rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo number_format($hotel['rating'], 1); ?></span>
                            </div>
                        </div>
                        <div class="hotel-body">
                            <h3 class="hotel-title"><?php echo htmlspecialchars($hotel['name']); ?></h3>
                            <p class="hotel-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($hotel['location']); ?>
                            </p>
                            <p class="hotel-desc"><?php echo htmlspecialchars($hotel['description']); ?></p>
                            
                            <?php if (isset($hotel['facilities'])): ?>
                                <div class="hotel-facilities">
                                    <?php foreach (array_slice($hotel['facilities'], 0, 3) as $facility): ?>
                                        <span class="facility-tag">
                                            <i class="fas fa-check"></i>
                                            <?php echo htmlspecialchars($facility); ?>
                                        </span>
                                    <?php endforeach; ?>
                                    <?php if (count($hotel['facilities']) > 3): ?>
                                        <span class="facility-more">+<?php echo count($hotel['facilities']) - 3; ?> more</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="hotel-price">
                                <span class="price-label">Starting from</span>
                                <span class="price-amount"><?php echo Utils::formatCurrency($hotel['price']); ?>/night</span>
                            </div>
                            
                            <div class="hotel-card-user">
                                <img src="/images/<?php echo strtolower(str_replace(' ', '', $hotel['user'])); ?>.png" 
                                     alt="<?php echo htmlspecialchars($hotel['user']); ?>" 
                                     class="user-avatar">
                                <span>Managed by <?php echo htmlspecialchars($hotel['user']); ?></span>
                            </div>
                            
                            <div class="hotel-card-actions">
                                <a href="/hotel/<?php echo $hotel['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <a href="/booking.php?hotel_id=<?php echo $hotel['id']; ?>" class="btn btn-success">
                                    <i class="fas fa-calendar-check"></i> Book Now
                                </a>
                                <button class="btn btn-outline favorite-btn" 
                                        data-hotel-id="<?php echo $hotel['id']; ?>" 
                                        title="Add to Favorites">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (empty($hotels)): ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No hotels found</h3>
                    <p>Try adjusting your search criteria or browse all hotels.</p>
                </div>
            <?php endif; ?>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Unggul Booking Hotel. All rights reserved.</p>
        </footer>
    </div>

    <div class="sidebar-overlay"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="/images/logo.png" alt="Company Logo" class="sidebar-logo-img">
            <span class="sidebar-company-name">Menu</span>
            <button id="closeSidebar" class="close-sidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php echo renderNavigation(); ?>
        
        <div class="about-us-section">
            <h3 class="about-us-title">TENTANG KAMI</h3>
            <p class="about-us-text">
                Kami adalah layanan properti modern yang fokus pada penyewaan hotel—tempat di mana 
                kenyamanan, kemudahan, dan gaya hidup bertemu. Lewat platform kami, kamu bisa menemukan 
                berbagai pilihan hotel yang pas buat liburan santai, urusan kerja, atau sekadar short 
                escape dari rutinitas.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const searchInput = document.getElementById('searchInput');
            const locationSelect = document.getElementById('locationSelect');
            const hotelCards = document.querySelectorAll('.hotel-card');

            // Sidebar functionality
            function openSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebarFunc() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }
            
            if (closeSidebar) {
                closeSidebar.addEventListener('click', closeSidebarFunc);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeSidebarFunc);
            }

            // Search and filter functionality
            function filterHotels() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedLocation = locationSelect.value.toLowerCase();

                hotelCards.forEach(card => {
                    const hotelName = card.querySelector('.hotel-title').textContent.toLowerCase();
                    const hotelLocation = card.dataset.location;
                    
                    const matchesSearch = hotelName.includes(searchTerm);
                    const matchesLocation = selectedLocation === 'all' || hotelLocation.includes(selectedLocation);
                    
                    if (matchesSearch && matchesLocation) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterHotels);
            locationSelect.addEventListener('change', filterHotels);

            // Favorite functionality
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hotelId = this.dataset.hotelId;
                    const icon = this.querySelector('i');
                    const isFavorited = icon.classList.contains('fas');
                    
                    fetch(`/hotel/${hotelId}/${isFavorited ? 'unfavorite' : 'favorite'}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (isFavorited) {
                                icon.classList.replace('fas', 'far');
                                this.title = 'Add to Favorites';
                            } else {
                                icon.classList.replace('far', 'fas');
                                this.title = 'Remove from Favorites';
                            }
                        } else {
                            alert(data.error || 'An error occurred');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'm') {
                    e.preventDefault();
                    if (sidebar.classList.contains('active')) {
                        closeSidebarFunc();
                    } else {
                        openSidebar();
                    }
                }
            });
        });
    </script>
</body>
</html>
