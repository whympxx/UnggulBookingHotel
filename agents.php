<?php
// hotel_data.php - Mock data to represent hotel details, replace with actual database queries.
$hotels = [
    [
        'name' => 'Hotel Santika Prime',
        'location' => 'Harapan Indah Bekasi',
        'price' => 'Rp. 688.750/Night',
        'user' => 'Larry Naves',
        'image' => 'HotelSantika.jpg',
        'rating' => '4.5',
        'description' => 'Luxury hotel with modern amenities',
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Fitness Center', 'Restaurant']
    ],
    [
        'name' => ' Hotel Royal Ambarukmo',
        'location' => 'Jogjakarta',
        'price' => 'Rp. 1.588.755/Night',
        'user' => 'Robert',
        'image' => 'royal-ambarukmo.jpg',
        'rating' => '4.8',
        'description' => 'Historic luxury hotel in Yogyakarta',
        'facilities' => ['Free Wi-Fi', 'Spa', 'Restaurant', 'Meeting Rooms']
    ],
    [
        'name' => 'Hotel Novotel',
        'location' => 'Bandung',
        'price' => 'Rp. 653.801/Night',
        'user' => 'Jessica',
        'image' => 'HotelNovotel.jpg',
        'rating' => '4.6',
        'description' => 'Contemporary comfort in Bandung',
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Bar', 'Family Rooms']
    ],
    [
        'name' => 'Hotel Fairfield',
        'location' => 'Bali',
        'price' => 'Rp. 1.131.350/Night',
        'user' => 'Jefri Nichol',
        'image' => 'fairfield.jpg',
        'rating' => '4.7',
        'description' => 'Beachfront paradise in Bali',
        'facilities' => ['Beach Access', 'Outdoor Pool', 'Restaurant', 'Spa']
    ],
    [
        'name' => 'Hotel Kempinski',
        'location' => 'Jakarta Pusat',
        'price' => 'Rp. 688.750/Night',
        'user' => 'Marco Van Basten',
        'image' => 'HotelKempinski.jpg',
        'rating' => '4.9',
        'description' => 'Luxury 5-star hotel in central Jakarta',
        'facilities' => ['Luxury Spa', 'Rooftop Pool', 'Fine Dining', 'Executive Lounge']
    ],
    // More hotels can be added
];

// Extract unique agents from the hotel data and add more details
$agents = [
    'Larry Naves' => [
        'name' => 'Larry Naves',
        'image' => 'larrynaves.png',
        'description' => 'Dengan pengalaman lebih dari 5 tahun di industri properti dan perhotelan, Larry Naves merupakan profesional yang berfokus pada penyewaan hotel untuk kebutuhan bisnis dan pariwisata. Sebagai bagian dari agensi properti terkemuka, Larry Naves, ia telah membantu puluhan klien menemukan properti hotel terbaik sesuai kebutuhan dan anggaran.',
        'location' => 'Perumahan Graha Blok J No 21, Bojong Rawa, Bekasi Barat, Kota Bekasi',
        'phone' => '+62-0852-2890-7619',
        'email' => 'navesld@gmail.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    'Robert' => [
        'name' => 'Robert',
        'image' => 'robert.png',
        'description' => 'Seorang agen berpengalaman dengan fokus pada properti komersial.',
        'location' => 'Jakarta',
        'phone' => '+62-812-3456-7890',
        'email' => 'robert@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    'Jessica' => [
        'name' => 'Jessica',
        'image' => 'jessica.png',
        'description' => 'Agen properti terkemuka di bidang perumahan mewah.',
        'location' => 'Surabaya',
        'phone' => '+62-812-9876-5432',
        'email' => 'jessica@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    'Jefri Nichol' => [
        'name' => 'Jefri Nichol',
        'image' => 'jefrinichol.png',
        'description' => 'Spesialis properti liburan di Bali dan sekitarnya.',
        'location' => 'Bali',
        'phone' => '+62-878-1122-3344',
        'email' => 'jefri@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    'Marco Van Basten' => [
        'name' => 'Marco Van Basten',
        'image' => 'marcovanbasten.png',
        'description' => 'Konsultan properti ahli untuk investasi jangka panjang.',
        'location' => 'Bandung',
        'phone' => '+62-896-5544-3322',
        'email' => 'marco@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agents</title>
    <link rel="stylesheet" href="agents.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">
            <img src="images/logo.png" alt="Company Logo"> Unggul Hotel Booking
        </a>
        <nav class="navbar">
            <a href="index.php">Beranda</a>
            <a href="layanan.php">Layanan</a>
            <a href="properties.php">Properties</a>
            <a href="agents.php" class="active">Agent</a>
        </nav>
        <a href="login.php" class="login-btn">Login</a>
    </header>

    <div class="container">
        <h1>Our Agents</h1>

        <div class="section">
            <h2>Meet Our Dedicated Agents</h2>
            <div class="agent-grid">
                <?php foreach($agents as $agent): ?>
                    <div class="agent-card" data-agent='<?php echo json_encode($agent); ?>'>
                        <img src="images/<?= $agent['image']; ?>" alt="<?= $agent['name']; ?>">
                        <h3><?= $agent['name']; ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="agent-profile-section" id="agentProfileSection" style="display: none;">
            <button class="close-profile-btn" id="closeProfileBtn">&times;</button>
            <div class="agent-profile-card">
                <div class="agent-profile-header">
                    <img src="" alt="Agent Profile Picture" class="agent-profile-pic" id="agentProfilePic">
                    <h2 id="agentProfileName"></h2>
                </div>
                <p id="agentProfileDescription"></p>
                <div class="agent-contact-info">
                    <p><i class='bx bx-map'></i> <span id="agentProfileLocation"></span></p>
                    <p><i class='bx bx-phone'></i> <span id="agentProfilePhone"></span></p>
                    <p><i class='bx bx-envelope'></i> <span id="agentProfileEmail"></span></p>
                </div>
                <div class="agent-social-links" id="agentSocialLinks">
                    <!-- Social links will be inserted here by JavaScript -->
                </div>
            </div>

            <h2 class="section-title" id="propertiesByAgentTitle"></h2>
            <div class="hotel-list" id="agentPropertiesList">
                <!-- Hotels by agent will be loaded here by JavaScript -->
            </div>
        </div>

        <!-- Hotel Detail Section -->
        <div class="hotel-detail-section" id="hotelDetailSection" style="display: none;">
            <button class="close-detail-btn" id="closeHotelDetailBtn">&times;</button>
            <div class="hotel-detail-card">
                <img src="" alt="Hotel Image" class="hotel-detail-img" id="hotelDetailImg">
                <div class="hotel-detail-content">
                    <h2 id="hotelDetailName"></h2>
                    <p><i class='bx bx-map'></i> <span id="hotelDetailLocation"></span></p>
                    <p class="hotel-detail-price" id="hotelDetailPrice"></p>
                    <p class="hotel-detail-description" id="hotelDetailDescription"></p>
                    <div class="hotel-facilities" id="hotelFacilities">
                        <h4>Facilities:</h4>
                        <ul>
                            <!-- Facilities will be inserted here by JavaScript -->
                        </ul>
                    </div>
                    <div class="agent-detail-info">
                        <h3>Agent: <span id="hotelDetailAgentName"></span></h3>
                        <p><i class='bx bx-phone'></i> <span id="hotelDetailAgentPhone"></span></p>
                        <p><i class='bx bx-envelope'></i> <span id="hotelDetailAgentEmail"></span></p>
                        <div class="agent-detail-social" id="hotelDetailAgentSocial">
                            <!-- Agent social links here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

            // Add active state to current page link
            const currentPage = window.location.pathname.split('/').pop();
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === '' && href === '#')) {
                    link.classList.add('active');
                }
            });

            // Agent profile functionality
            const agentCards = document.querySelectorAll('.agent-card');
            const agentProfileSection = document.getElementById('agentProfileSection');
            const agentProfilePic = document.getElementById('agentProfilePic');
            const agentProfileName = document.getElementById('agentProfileName');
            const agentProfileDescription = document.getElementById('agentProfileDescription');
            const agentProfileLocation = document.getElementById('agentProfileLocation');
            const agentProfilePhone = document.getElementById('agentProfilePhone');
            const agentProfileEmail = document.getElementById('agentProfileEmail');
            const agentSocialLinks = document.getElementById('agentSocialLinks');
            const agentPropertiesList = document.getElementById('agentPropertiesList');
            const propertiesByAgentTitle = document.getElementById('propertiesByAgentTitle');
            const closeProfileBtn = document.getElementById('closeProfileBtn');
            const agentGridSection = document.querySelector('.section'); // The section containing the agent grid

            const hotelsData = <?php echo json_encode($hotels); ?>;

            agentCards.forEach(card => {
                card.addEventListener('click', function() {
                    const agent = JSON.parse(this.getAttribute('data-agent'));

                    // Populate agent profile
                    agentProfilePic.src = 'images/' + agent.image;
                    agentProfileName.textContent = agent.name;
                    agentProfileDescription.textContent = agent.description;
                    agentProfileLocation.textContent = agent.location;
                    agentProfilePhone.textContent = agent.phone;
                    agentProfileEmail.textContent = agent.email;

                    // Populate social links
                    agentSocialLinks.innerHTML = '';
                    for (const platform in agent.social) {
                        if (agent.social[platform] !== '#') {
                            const link = document.createElement('a');
                            link.href = agent.social[platform];
                            link.target = '_blank';
                            let iconClass = '';
                            if (platform === 'facebook') iconClass = 'fab fa-facebook-f';
                            else if (platform === 'instagram') iconClass = 'fab fa-instagram';
                            else if (platform === 'x') iconClass = 'fab fa-twitter'; // 'x' is typically Twitter

                            link.innerHTML = `<i class="${iconClass}"></i>`;
                            agentSocialLinks.appendChild(link);
                        }
                    }

                    // Filter and display hotels by this agent
                    const agentHotels = hotelsData.filter(hotel => hotel.user === agent.name);
                    agentPropertiesList.innerHTML = '';
                    propertiesByAgentTitle.textContent = `Properties by ${agent.name}`;

                    if (agentHotels.length > 0) {
                        agentHotels.forEach(hotel => {
                            const hotelCard = document.createElement('div');
                            hotelCard.classList.add('hotel-card');
                            hotelCard.innerHTML = `
                                <img src="images/${hotel.image}" alt="${hotel.name}">
                                <h3>${hotel.name}</h3>
                                <p><i class=\'bx bx-map\'></i> ${hotel.location}</p>
                                <p><strong>${hotel.price}</strong></p>
                                <div class="card-bottom">
                                    <div class="user-info">
                                        <img src="images/${agent.image}" alt="${hotel.user}">
                                        <span>${hotel.user}</span>
                                    </div>
                                    <button class="view-details-btn" data-hotel='${JSON.stringify(hotel)}' data-agent-name="${agent.name}">View Details</button>
                                </div>
                            `;
                            agentPropertiesList.appendChild(hotelCard);
                        });
                    } else {
                        agentPropertiesList.innerHTML = '<p>No properties listed by this agent yet.</p>';
                    }

                    // Show agent profile section and hide agent grid
                    agentGridSection.style.display = 'none';
                    agentProfileSection.style.display = 'block';

                    // Add event listeners for new "View Details" buttons AFTER they are added to the DOM
                    document.querySelectorAll('.view-details-btn').forEach(button => {
                        button.addEventListener('click', function(event) {
                            event.stopPropagation(); // Prevent agent card click from firing again
                            const hotel = JSON.parse(this.getAttribute('data-hotel'));
                            const agentName = this.getAttribute('data-agent-name');
                            const agentsData = <?php echo json_encode($agents); ?>;
                            const agent = agentsData[agentName];

                            // Populate hotel detail section
                            document.getElementById('hotelDetailImg').src = 'images/' + hotel.image;
                            document.getElementById('hotelDetailName').textContent = hotel.name;
                            document.getElementById('hotelDetailLocation').textContent = hotel.location;
                            document.getElementById('hotelDetailPrice').textContent = hotel.price;
                            document.getElementById('hotelDetailDescription').textContent = hotel.description;

                            // Populate hotel facilities
                            const hotelFacilitiesList = document.getElementById('hotelFacilities').querySelector('ul');
                            hotelFacilitiesList.innerHTML = '';
                            if (hotel.facilities && hotel.facilities.length > 0) {
                                hotel.facilities.forEach(facility => {
                                    const li = document.createElement('li');
                                    li.textContent = facility;
                                    hotelFacilitiesList.appendChild(li);
                                });
                            } else {
                                hotelFacilitiesList.innerHTML = '<li>No facilities listed.</li>';
                            }

                            // Populate agent info in hotel detail
                            document.getElementById('hotelDetailAgentName').textContent = agent.name;
                            document.getElementById('hotelDetailAgentPhone').textContent = agent.phone;
                            document.getElementById('hotelDetailAgentEmail').textContent = agent.email;
                            const hotelDetailAgentSocial = document.getElementById('hotelDetailAgentSocial');
                            hotelDetailAgentSocial.innerHTML = '';
                            for (const platform in agent.social) {
                                if (agent.social[platform] !== '#') {
                                    const link = document.createElement('a');
                                    link.href = agent.social[platform];
                                    link.target = '_blank';
                                    let iconClass = '';
                                    if (platform === 'facebook') iconClass = 'fab fa-facebook-f';
                                    else if (platform === 'instagram') iconClass = 'fab fa-instagram';
                                    else if (platform === 'x') iconClass = 'fab fa-twitter';
                                    link.innerHTML = `<i class="${iconClass}"></i>`;
                                    hotelDetailAgentSocial.appendChild(link);
                                }
                            }

                            // Show hotel detail section and hide agent profile section
                            agentProfileSection.style.display = 'none';
                            document.getElementById('hotelDetailSection').style.display = 'block';
                        });
                    });
                });
            });

            closeProfileBtn.addEventListener('click', function() {
                agentProfileSection.style.display = 'none';
                agentGridSection.style.display = 'block';
            });

            // Close hotel detail section
            document.getElementById('closeHotelDetailBtn').addEventListener('click', function() {
                document.getElementById('hotelDetailSection').style.display = 'none';
                agentProfileSection.style.display = 'block'; // Go back to agent profile
            });

            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-closed');
                if (mainBg) { // mainBg might not exist on all pages
                    mainBg.classList.toggle('main-expanded');
                }
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
                        if (mainBg) {
                            mainBg.classList.remove('main-expanded');
                        }
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

            // Handle cart button clicks (not relevant for agents.php, but kept for consistency if copied from index.php)
            const cartButtons = document.querySelectorAll('.add-to-cart-btn');
            cartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const hotelData = this.getAttribute('data-hotel');
                    let cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                    cartItems.push(JSON.parse(hotelData));
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));
                    window.location.href = 'cart.php';
                });
            });
        });
    </script>
</body>
</html> 