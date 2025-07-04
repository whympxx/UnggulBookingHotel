<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>
    <link rel="stylesheet" href="properties.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 80%;
            max-width: 1200px;
            position: relative;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #1e3c72;
        }

        .close-modal:hover {
            color: #2a5298;
        }

        .hotel-details {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .hotel-info {
            flex: 1;
            white-space: pre-line;
            line-height: 1.6;
            color: #666;
        }

        .hotel-info h3 {
            color: #1e3c72;
            margin-bottom: 15px;
            font-size: 1.4em;
        }

        .room-gallery {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .room-gallery img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .room-gallery img:hover {
            transform: scale(1.05);
        }

        .hotel-image {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .hotel-image:hover {
            transform: scale(1.02);
        }

        #modalHotelName {
            color: #1e3c72;
            font-size: 2em;
            margin-bottom: 10px;
        }

        #modalHotelLocation {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 20px;
        }
    </style>
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
            <a href="agents.php">Agent</a>
        </nav>
        <button class="login-btn">Login</button>
    </header>
    

    <div class="container">
        <h1>PROPERTIES</h1>

        <div class="section">
            <h2>Recommended Hotel</h2>
            <div class="hotel-grid">
                <!-- Hotel Card 1 -->
                <div class="hotel-card">
                    <img src="images/HotelSantika.jpg" alt="Hotel Santika Prime" class="hotel-image" 
                    data-description="Hotel Santika Prime menawarkan pengalaman menginap mewah dengan fasilitas lengkap:

• Kamar & Suite:
- 200+ kamar modern dengan pemandangan kota
- Suite mewah dengan balkon pribadi
- Tempat tidur king-size dengan kasur premium
- Smart TV 55&quot; dan sistem hiburan in-room

• Fasilitas:
- Kolam renang infinity dengan pemandangan kota
- Spa & Wellness Center dengan 8 ruang perawatan
- Pusat kebugaran 24 jam dengan peralatan modern
- 3 restoran internasional
- Lounge bar dengan live music
- Meeting rooms hingga 500 orang

• Layanan:
- Butler service 24 jam
- Free WiFi di seluruh area
- Shuttle service ke pusat kota
- Valet parking
- Laundry & dry cleaning service"
                    data-images='["images/Santika-room1.jpg", "images/Santika-room2.jpg", "images/Santika-room3.jpg", "images/Santika-room4.jpg"]'>
                    <div class="rating">4.5 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Santika Prime</h3>
                        <p><i class='bx bxs-map'></i> Harapan Indah Bekasi</p>
                        <p class="price">Rp. 688.750/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Santika Prime">
                                <input type="hidden" name="location" value="Harapan Indah Bekasi">
                                <input type="hidden" name="price" value="688750">
                                <input type="hidden" name="rating" value="4.5">
                                <input type="hidden" name="image" value="images/HotelSantika.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Santika Prime", "location": "Harapan Indah Bekasi", "price": "Rp. 688.750", "image": "HotelSantika.jpg", "rating": "4.5"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 2 -->
                <div class="hotel-card">
                    <img src="images/royal-ambarukmo.jpg" alt="Royal Ambarrukmo" class="hotel-image" 
                    data-description="Royal Ambarrukmo adalah hotel bersejarah dengan kemewahan modern:

• Kamar & Suite:
- 120 kamar dengan desain Jawa kontemporer
- Suite dengan pemandangan Gunung Merapi
- Bale-bale tradisional di balkon
- Bathtub mewah dengan pemandangan

• Fasilitas:
- Taman tropis seluas 2 hektar
- Kolam renang dengan air terjun
- Spa tradisional Jawa
- Restoran dengan konsep Rijsttafel
- Lounge dengan live gamelan
- Museum mini sejarah hotel

• Layanan:
- Tour guide ke tempat bersejarah
- Workshop batik & kerajinan
- Bicycle rental
- Shuttle ke Malioboro
- Traditional massage service"
                    data-images='["images/Ambarrukmo-room1.jpg", "images/Ambarrukmo-room2.jpg", "images/Ambarrukmo-room3.jpg", "images/Ambarrukmo-room4.jpg"]'>
                    <div class="rating">4.8 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Royal Ambarrukmo</h3>
                        <p><i class='bx bxs-map'></i> Jogjakarta</p>
                        <p class="price">Rp. 1.588.755/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/robert.png" alt="Robert">
                                <span>Robert</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Royal Ambarrukmo">
                                <input type="hidden" name="location" value="Jogjakarta">
                                <input type="hidden" name="price" value="1588755">
                                <input type="hidden" name="rating" value="4.8">
                                <input type="hidden" name="image" value="images/royal-ambarukmo.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Royal Ambarrukmo", "location": "Jogjakarta", "price": "Rp. 1.588.755", "image": "royal-ambarukmo.jpg", "rating": "4.8"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 3 -->
                <div class="hotel-card">
                    <img src="images/HotelNovotel.jpg" alt="Hotel Novotel" class="hotel-image" 
                    data-description="Novotel Bandung menawarkan kenyamanan modern:

• Kamar & Suite:
- 200+ kamar dengan desain kontemporer
- Suite dengan pemandangan kota
- Tempat tidur Novotel Sweet Bed™
- Smart TV dengan streaming service

• Fasilitas:
- Kolam renang indoor & outdoor
- Fitness center 24 jam
- Spa dengan 6 ruang perawatan
- 2 restoran internasional
- Rooftop bar
- Business center

• Layanan:
- Free WiFi premium
- Shuttle ke factory outlet
- Tour ke tempat wisata
- Business services
- Kids club & babysitting"
                    data-images='["images/Novotel-room1.jpg", "images/Novotel-room2.jpg", "images/Novotel-room3.jpg", "images/Novotel-room4.jpg"]'>
                    <div class="rating">4.6 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Novotel</h3>
                        <p><i class='bx bxs-map'></i> Bandung</p>
                        <p class="price">Rp. 853.801/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Novotel">
                                <input type="hidden" name="location" value="Bandung">
                                <input type="hidden" name="price" value="853801">
                                <input type="hidden" name="rating" value="4.6">
                                <input type="hidden" name="image" value="images/HotelNovotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Novotel", "location": "Bandung", "price": "Rp. 853.801", "image": "novotel.jpg", "rating": "4.6"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>All Hotels</h2>
            <div class="hotel-grid">
                <!-- Hotel Card 1 -->
                <div class="hotel-card">
                    <img src="images/spencer_green_hotel.jpg" alt="Spencer Green Hotel">
                    <div class="rating">4.2 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Spencer Green Hotel</h3>
                        <p><i class='bx bxs-map'></i> Malang, Batu</p>
                        <p class="price">Rp. 403.603/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Spencer Green Hotel">
                                <input type="hidden" name="location" value="Malang, Batu">
                                <input type="hidden" name="price" value="403603">
                                <input type="hidden" name="rating" value="4.2">
                                <input type="hidden" name="image" value="images/spencer_green_hotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Spencer Green Hotel", "location": "Malang, Batu", "price": "Rp. 403.603", "image": "spencer_green_hotel.jpg", "rating": "4.2"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 2 -->
                <div class="hotel-card">
                    <img src="images/royal-ambarukmo.jpg" alt="Royal Ambarrukmo">
                    <div class="rating">4.8 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Royal Ambarrukmo</h3>
                        <p><i class='bx bxs-map'></i> Jogjakarta</p>
                        <p class="price">Rp. 1.588.755/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/robert.png" alt="Robert">
                                <span>Robert</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Royal Ambarrukmo">
                                <input type="hidden" name="location" value="Jogjakarta">
                                <input type="hidden" name="price" value="1588755">
                                <input type="hidden" name="rating" value="4.8">
                                <input type="hidden" name="image" value="images/royal-ambarukmo.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Royal Ambarrukmo", "location": "Jogjakarta", "price": "Rp. 1.588.755", "image": "royal-ambarukmo.jpg", "rating": "4.8"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 3 -->
                <div class="hotel-card">
                    <img src="images/hotel trikora beach.jpg" alt="Hotel Trikora Beach">
                    <div class="rating">4.0 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Trikora Beach</h3>
                        <p><i class='bx bxs-map'></i> Bintan Regency, Riau</p>
                        <p class="price">Rp. 900.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Trikora Beach">
                                <input type="hidden" name="location" value="Bintan Regency, Riau">
                                <input type="hidden" name="price" value="900000">
                                <input type="hidden" name="rating" value="4.0">
                                <input type="hidden" name="image" value="images/hotel_trikora_beach.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Trikora Beach", "location": "Bintan Regency, Riau", "price": "Rp. 900.000", "image": "hotel_trikora_beach.jpg", "rating": "4.0"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 4 -->
                <div class="hotel-card">
                    <img src="images/HotelSantika.jpg" alt="Hotel Santika Prime">
                    <div class="rating">4.5 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Santika Prime</h3>
                        <p><i class='bx bxs-map'></i> Harapan Indah Bekasi</p>
                        <p class="price">Rp. 688.750/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Santika Prime">
                                <input type="hidden" name="location" value="Harapan Indah Bekasi">
                                <input type="hidden" name="price" value="688750">
                                <input type="hidden" name="rating" value="4.5">
                                <input type="hidden" name="image" value="images/HotelSantika.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Santika Prime", "location": "Harapan Indah Bekasi", "price": "Rp. 688.750", "image": "HotelSantika.jpg", "rating": "4.5"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 5 -->
                <div class="hotel-card">
                    <img src="images/hotelContinental.jpg" alt="Hotel Continental">
                    <div class="rating">4.3 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Continental</h3>
                        <p><i class='bx bxs-map'></i> Badung, Bali</p>
                        <p class="price">Rp. 850.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/robert.png" alt="Robert">
                                <span>Robert</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Continental">
                                <input type="hidden" name="location" value="Badung, Bali">
                                <input type="hidden" name="price" value="850000">
                                <input type="hidden" name="rating" value="4.3">
                                <input type="hidden" name="image" value="images/hotel_continental.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Continental", "location": "Badung, Bali", "price": "Rp. 850.000", "image": "hotel_continental.jpg", "rating": "4.3"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 6 -->
                <div class="hotel-card">
                    <img src="images/HotelNovotel.jpg" alt="Hotel Novotel Bandung">
                    <div class="rating">4.6 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Novotel</h3>
                        <p><i class='bx bxs-map'></i> Bandung</p>
                        <p class="price">Rp. 853.801/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Novotel">
                                <input type="hidden" name="location" value="Bandung">
                                <input type="hidden" name="price" value="853801">
                                <input type="hidden" name="rating" value="4.6">
                                <input type="hidden" name="image" value="images/novotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Novotel", "location": "Bandung", "price": "Rp. 853.801", "image": "novotel.jpg", "rating": "4.6"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="hotelModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modalHotelName"></h2>
            <p id="modalHotelLocation"></p>
            <div class="hotel-details">
                <div class="hotel-info"></div>
                <div class="room-gallery"></div>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById('hotelModal');
        const closeBtn = document.querySelector('.close-modal');
        const hotelImages = document.querySelectorAll('.hotel-image');

        hotelImages.forEach(img => {
            img.addEventListener('click', function() {
                const hotelName = this.parentElement.querySelector('h3').textContent;
                const hotelLocation = this.parentElement.querySelector('p').textContent;
                const description = this.getAttribute('data-description');
                const images = JSON.parse(this.getAttribute('data-images'));

                document.getElementById('modalHotelName').textContent = hotelName;
                document.getElementById('modalHotelLocation').textContent = hotelLocation;
                document.querySelector('.hotel-info').innerHTML = description;

                const gallery = document.querySelector('.room-gallery');
                gallery.innerHTML = '';
                images.forEach(image => {
                    const img = document.createElement('img');
                    img.src = image;
                    img.alt = `${hotelName} Room`;
                    gallery.appendChild(img);
                });

                modal.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Tambahkan script tombol keranjang
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const hotelData = this.getAttribute('data-hotel');
                let cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
                cartItems.push(JSON.parse(hotelData));
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                window.location.href = 'cart.php';
            });
        });

        // Tambahkan event handler untuk tombol login
        document.querySelector('.login-btn').addEventListener('click', function() {
            window.location.href = 'login.php';
        });
    </script>
</body>
</html> 