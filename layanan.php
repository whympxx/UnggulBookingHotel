<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Hotel</title>
    <link rel="stylesheet" href="layanan.css">
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
        }

        .hotel-info h3 {
            color: #333;
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
            color: #333;
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
        <h1>LAYANAN HOTEL</h1>

        <div class="section">
            <h2>Hotel dengan Layanan Terbaik</h2>
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
                    data-images='["images/santika-room1.jpg", "images/santika-room2.jpg", "images/santika-room3.jpg", "images/santika-room4.jpg"]'>
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
                    data-images='["images/ambarrukmo-room1.jpg", "images/ambarrukmo-room2.jpg", "images/ambarrukmo-room3.jpg", "images/ambarrukmo-room4.jpg"]'>
                    <div class="rating">4.8 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Royal Ambarrukmo</h3>
                        <p><i class='bx bxs-map'></i> Yogyakarta</p>
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
                    data-images='["images/novotel-room1.jpg", "images/novotel-room2.jpg", "images/novotel-room3.jpg", "images/novotel-room4.jpg"]'>
                    <div class="rating">4.6 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Novotel</h3>
                        <p><i class='bx bxs-map'></i> Bandung</p>
                        <p class="price">Rp. 653.801/Night</p>
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
                                data-hotel='{"name": "Hotel Novotel", "location": "Bandung", "price": "Rp. 653.801", "image": "novotel.jpg", "rating": "4.6"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                                <!-- Hotel Card 4 -->
                <div class="hotel-card">
                    <img src="images/fairfield.jpg" alt="Hotel Fairfield" class="hotel-image"
                    data-description="Fairfield Bali menawarkan kenyamanan modern:

• Kamar & Suite:
- 200+ kamar dengan desain kontemporer
- Suite dengan pemandangan kota
- Tempat tidur Fairfield Sweet Bed™
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
                    data-images='["images/Fairfield-room1.jpg", "images/Fairfield-room2.jpg", "images/Fairfield-room3.jpg", "images/Fairfield-room4.jpg"]'>
                    <div class="rating">4.6 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Fairfield</h3>
                        <p><i class='bx bxs-map'></i> Bali</p>
                        <p class="price">Rp. 1.131.350/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/jefrinichol.png" alt="Jefri Nichol">
                                <span>Jefri Nichol</span>
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
                                data-hotel='{"name": "Hotel Fairfield", "location": "Bali", "price": "Rp. 1.131.350", "image": "fairfield.jpg", "rating": "4.6"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 5 -->
                <div class="hotel-card">
                    <img src="images/HotelKempinski.jpg" alt="Hotel Kempinski" class="hotel-image"
                    data-description="Hotel Kempinski Jakarta Pusat menawarkan kenyamanan dan kemudahan:
• Kamar & Suite:
- 150+ kamar dengan desain modern
- Suite dengan ruang tamu terpisah
- Tempat tidur nyaman
- Smart TV dengan berbagai saluran
• Fasilitas:
- Kolam renang outdoor
- Pusat kebugaran
- Restoran dengan masakan lokal
- Ruang pertemuan

• Layanan:
- WiFi gratis
- Layanan kamar 24 jam
- Layanan laundry
- Parkir gratis"
                    data-images='["images/Kempinski-room1.jpg", "images/Kempinski-room2.jpg", "images/Kempinski-room3.jpg", "images/Kempinski-room4.jpg"]'>
                    <div class="rating">4.5 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Kempinski</h3>
                        <p><i class='bx bxs-map'></i> Jakarta Pusat</p>
                        <p class="price">Rp. 688.750/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/marcovanbasten.png" alt="Marco Van Basten">
                                <span>Marco Van Basten</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Holiday Inn">
                                <input type="hidden" name="location" value="Bandung">
                                <input type="hidden" name="price" value="900000">
                                <input type="hidden" name="rating" value="4.5">
                                <input type="hidden" name="image" value="images/holiday-inn.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Kempinski", "location": "Jakarta Pusat", "price": "Rp. 688.750", "image": "Kempinski.jpg", "rating": "4.5"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <div class="section">
            <h2>Layanan Hotel</h2>
            <div class="hotel-grid">
                <!-- Hotel Card 1 -->
                <div class="hotel-card">
                    <img src="images/spencer_green_hotel.jpg" alt="Hotel Spencer Green" class="hotel-image"
                    data-description="Spencer Green Hotel di Malang adalah hotel yang sangat direkomendasikan yang menawarkan pengalaman menginap yang nyaman dengan fasilitas yang baik, pemandangan yang menyenangkan, dan akses mudah ke berbagai objek wisata populer di Batu.:

• Fasilitas:
- Kamar: Menawarkan berbagai tipe kamar seperti Deluxe Twin/Double dan Executive Twin/Double, serta Superior Triple. Kamar-kamar umumnya dilengkapi dengan AC, TV layar datar, meja kerja, WiFi gratis, dan kamar mandi pribadi dengan shower. Beberapa kamar memiliki balkon dengan pemandangan gunung.
- Kolam Renang: Tersedia kolam renang outdoor dan kolam renang anak.
- Kuliner: Memiliki restoran di tempat yang menyajikan masakan lokal dan internasional, serta kafe rooftop dengan pemandangan panorama. Layanan kamar juga tersedia.
- Spa: Menyediakan layanan spa untuk relaksasi.
- Rekreasi: Menawarkan karaoke keluarga, taman, dan terkadang aktivitas outdoor.
- Spa dengan konsep alami

• Layanan:
- Parkir mandiri gratis.
- Meja depan 24 jam dengan layanan concierge.
- Penyimpanan bagasi dan brankas.
- Ruang pertemuan.
- Layanan binatu/cuci kering.
- Wi-Fi gratis di seluruh properti."
                    data-images='["images/Spencer Green-room1.jpg", "images/Spencer Green-room2.jpg", "images/Spencer Green-room3.jpg", "images/Spencer Green-room4.jpg"]'>
                    <div class="rating">4.7 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Spencer Green</h3>
                        <p><i class='bx bxs-map'></i> Malang Batu </p>
                        <p class="price">Rp. 403.603/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Spencer Green">
                                <input type="hidden" name="location" value="Malang Batu">
                                <input type="hidden" name="price" value="1131350">
                                <input type="hidden" name="rating" value="4.7">
                                <input type="hidden" name="image" value="images/spencer_green_hotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Spencer Green", "location": "Malang Batu", "price": "Rp. 403.603", "image": "spencer_green_hotel.jpg", "rating": "4.7"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 2 -->
                <div class="hotel-card">
                    <img src="images/Hotel aston bekasi.jpg" alt="Hotel Aston" class="hotel-image"
                    data-description="Aston Imperial Bekasi Hotel adalah pilihan yang solid bagi Anda yang mencari akomodasi nyaman dengan fasilitas lengkap dan lokasi strategis di Bekasi Barat.:

• Kamar & Suite:
- 180 kamar dengan desain mewah
- Presidential suite dengan 3 kamar
- Tempat tidur Kempinski premium
- Smart room control system

• Fasilitas:
- Rooftop infinity pool
- Spa dengan 12 ruang perawatan
- Fitness center dengan personal trainer
- 5 restoran bintang Michelin
- Cigar lounge
- Ballroom untuk 1000 orang

• Layanan:
- 24/7 butler service
- Private jet & helicopter service
- Luxury car rental
- Personal shopping service
- Executive lounge access"
                    data-images='["images/Aston Bekasi-room1.jpg", "images/Aston Bekasi-room2.jpg", "images/Aston Bekasi-room3.jpg", "images/Aston Bekasi-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Aston Imperial</h3>
                        <p><i class='bx bxs-map'></i>Bekasi Barat</p>
                        <p class="price">Rp. 613.676/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Aston Imperial">
                                <input type="hidden" name="location" value="Bekasi Barat">
                                <input type="hidden" name="price" value="681750">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/Hotel aston bekasi.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Aston Imperial", "location": "Bekasi Barat", "price": "Rp. 613.676", "image": "Hotel aston bekasi.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 3 -->
                <div class="hotel-card">
                    <img src="images/Hotel trikora beach.jpg" alt="Trikora Beach" class="hotel-image"
                    data-description="Pantai Trikora adalah destinasi yang sempurna bagi Anda yang mencari ketenangan dan keindahan alam bahari di Pulau Bintan.:

• Kamar & Suite:
- 150+ kamar dan vila dengan pemandangan laut dan taman
- Suite keluarga dengan area bermain anak
- Tempat tidur nyaman dengan linen kualitas premium
- Wifi kecepatan tinggi

• Fasilitas:
- Kolam renang infinity dengan pemandangan pantai
- Spa dengan layanan pijat tradisional Bintan
- Pusat aktivitas air (snorkeling, kayak, paddleboard)
- 3 restoran dengan hidangan laut segar dan masakan lokal
- Kids club dengan program edukatif
- Area api unggun di tepi pantai

• Layanan:
- Resepsionis 24/7
- Antar jemput bandara
- Penyewaan sepeda dan skuter
- Tur lokal dan island hoppin
- Kelas memasak dan masakan lokal"
                    data-images='["images/Trikora Beach-room1.jpg", "images/Trikora Beach-room2.jpg", "images/Trikora Beach-room3.jpg", "images/Trikora Beach-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Trikora Beach</h3>
                        <p><i class='bx bxs-map'></i>Bintan Regency, Riau</p>
                        <p class="price">Rp. 900.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Trikora Beach">
                                <input type="hidden" name="location" value="Bintan Regency, Riau">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/Hotel trikora beach.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Trikora Beach", "location": "Bintan Regency, Riau", "price": "Rp. 900.000", "image": "Hotel trikora beach.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Card 4 -->
                <div class="hotel-card">
                    <img src="images/HotelSantika.jpg" alt="Hotel Santika" class="hotel-image"
                    data-description="Hotel Santika yang lengkap, dan pilihan menu sarapan yang bervariasi. Kedua hotel ini menawarkan pengalaman menginap yang nyaman dengan fasilitas yang memadai, disesuaikan dengan segmen bintang masing-masing, dan merupakan pilihan populer di Bekasi.:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota bekasi
- Santika suite dengan butler pribadi
- Tempat tidur Santika signature
- Smart home system

• Fasilitas:
- Sky pool dengan pemandangan 360°
- Spa dengan 15 ruang perawatan
- Fitness center dengan view kota
- 6 restoran bintang Michelin
- Club lounge eksklusif
- Grand ballroom

• Layanan:
- Personal butler 24/7
- Private jet & limousine service
- Concierge service premium
- Personal shopping & styling
- Exclusive club access"
                    data-images='["images/Santika-room1.jpg", "images/Santika-room2.jpg", "images/Santika-room3.jpg", "images/Santika-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Santika Prime</h3>
                        <p><i class='bx bxs-map'></i>Harapan Indah Bekasi</p>
                        <p class="price">Rp. 688.750/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/larrynaves.png" alt="Larry Naves">
                                <span>Larry Naves</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Santika Prime">
                                <input type="hidden" name="location" value="Harapan Indah Bekasi">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/HotelSantika.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Santika Prime", "location": "Harapan Indah Bekasi", "price": "Rp. 688.750", "image": "HotelSantika.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                    <!-- Hotel Card 5 -->
                <div class="hotel-card">
                    <img src="images/HotelContinental.jpg" alt="Hotel Continental" class="hotel-image"
                    data-description="InterContinental Hotel Dago Pakar Bandung adalah pilihan sempurna bagi Anda yang mencari kemewahan, ketenangan, dan keindahan alam dalam satu paket di Bandung.:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota
- InterContinental suite dengan butler pribadi
- Smart home system

• Fasilitas:
- Tempat tidur premium
- Kamar mandi mewah
- Teknologi Modern
- Fasilitas lengkap dan mendukung
- Kids Club

• Layanan:
- Resepsionis 24/7
- Layanan Concierge
- Layanan kamar 24 jam
- Antar - Jemput (Bandara/Lokal)
- Valet Parking
- Wifi gratis"
                    data-images='["images/Continental-room1.jpg", "images/Continental-room2.jpg", "images/Continental-room3.jpg", "images/Continental-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Continental</h3>
                        <p><i class='bx bxs-map'></i>Cimenyan, Bandung</p>
                        <p class="price">Rp. 850.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/robert.png" alt="Robert">
                                <span>Robert</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Continental">
                                <input type="hidden" name="location" value="Cimenyan, Bandung">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/HotelContinental.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Continental", "location": "Cimenyan, Bandung", "price": "Rp. 850.000", "image": "HotelContinental.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 6 -->
                <div class="hotel-card">
                    <img src="images/HotelNovotel.jpg" alt="Hotel Novotel" class="hotel-image"
                    data-description="The Ritz-Carlton Jakarta menawarkan kemewahan tertinggi:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota
- Ritz-Carlton suite dengan butler pribadi
- Tempat tidur Ritz-Carlton signature
- Smart home system

• Fasilitas:
- Sky pool dengan pemandangan 360°
- Spa dengan 15 ruang perawatan
- Fitness center dengan view kota
- 6 restoran bintang Michelin
- Club lounge eksklusif
- Grand ballroom

• Layanan:
- Personal butler 24/7
- Private jet & limousine service
- Concierge service premium
- Personal shopping & styling
- Exclusive club access"
                    data-images='["images/Novotel-room1.jpg", "images/Novotel-room2.jpg", "images/Novotel-room3.jpg", "images/Novotel-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Novotel</h3>
                        <p><i class='bx bxs-map'></i>Bandung</p>
                        <p class="price">Rp. 653.801/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Novotel">
                                <input type="hidden" name="location" value="Bandung">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/HotelNovotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Novotel", "location": "Bandung", "price": "Rp. 653.801", "image": "HotelNovotel.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 7 -->
                <div class="hotel-card">
                    <img src="images/fairfield.jpg" alt="Hotel Fairfield" class="hotel-image"
                    data-description="The Ritz-Carlton Jakarta menawarkan kemewahan tertinggi:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota
- Ritz-Carlton suite dengan butler pribadi
- Tempat tidur Ritz-Carlton signature
- Smart home system

• Fasilitas:
- Sky pool dengan pemandangan 360°
- Spa dengan 15 ruang perawatan
- Fitness center dengan view kota
- 6 restoran bintang Michelin
- Club lounge eksklusif
- Grand ballroom

• Layanan:
- Personal butler 24/7
- Private jet & limousine service
- Concierge service premium
- Personal shopping & styling
- Exclusive club access"
                    data-images='["images/Fairfield-room1.jpg", "images/Fairfield-room2.jpg", "images/Fairfield-room3.jpg", "images/Fairfield-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Fairfield</h3>
                        <p><i class='bx bxs-map'></i>Bali</p>
                        <p class="price">Rp. 1.131.350/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/jefrinichol.png" alt="Jefri Nichol">
                                <span>Jefri Nichol</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Fairfield">
                                <input type="hidden" name="location" value="Bali">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/fairfield.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Fairfield", "location": "Bali", "price": "Rp. 1.131.350", "image": "fairfield.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 8 -->
                <div class="hotel-card">
                    <img src="images/The Phoneix Hotel.jpg" alt="Hotel The Phoneix" class="hotel-image"
                    data-description="The Ritz-Carlton Jakarta menawarkan kemewahan tertinggi:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota
- Ritz-Carlton suite dengan butler pribadi
- Tempat tidur Ritz-Carlton signature
- Smart home system

• Fasilitas:
- Sky pool dengan pemandangan 360°
- Spa dengan 15 ruang perawatan
- Fitness center dengan view kota
- 6 restoran bintang Michelin
- Club lounge eksklusif
- Grand ballroom

• Layanan:
- Personal butler 24/7
- Private jet & limousine service
- Concierge service premium
- Personal shopping & styling
- Exclusive club access"
                    data-images='["images/The Phoneix-room1.jpg", "images/The Phoneix-room2.jpg", "images/The Phoneix-room3.jpg", "images/The Phoneix-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel The Phoneix</h3>
                        <p><i class='bx bxs-map'></i>Jetis, Kota Yogyakarta</p>
                        <p class="price">Rp. 1.245.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/marcovanbasten.png" alt="Marco Van Basten">
                                <span>Marco Van Basten</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel The Phoneix">
                                <input type="hidden" name="location" value="Jetis, Kota Yogyakarta">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/The Phoneix Hotel.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel The Phoneix", "location": "Jetis, Kota Yogyakarta", "price": "Rp. 1.245.000", "image": "The Phoneix Hotel.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 9 -->
                <div class="hotel-card">
                    <img src="images/Hotel bali resort.jpg" alt="Hotel Bali Resort" class="hotel-image"
                    data-description="Hotel Bali Resort adalah pilihan ideal bagi Anda yang mencari liburan yang menenangkan, penuh inspirasi, dan mendalam di tengah keindahan dan keramahan Bali.:

• Kamar & Suite:
- 250+ kamar dengan pemandangan taman tropis atau kolam renang
- vila pribadi dengan kolam renang privat
- Tempat tidur premium dengan linen berkualitas tinggi
- Sistem pendingin independen

• Fasilitas:
- Kolam renang berbentuk laguna dengan area berjemur
- Spa tradisional Bali dengan 10 ruang perawatan
- Pusat kebugaran dengan peralatan modern
- 3 restoran dengan masakan Bali dan Internasional
- Bar tepi kolam renang
- Ruang serbaguna untuk acara dan pertemuan

• Layanan:
- Layanan pramutamu 24/7
- Layanan antar-jemput bandara
- Penyewaan kendaraan
- Layanan kamar 24 jam
- Jasa penukaran mata uang
- Layanan penitipan anak (atas permintaan)"
                    data-images='["images/Bali Resort-room1.jpg", "images/Bali Resort-room2.jpg", "images/Bali Resort-room3.jpg", "images/Bali Resort-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Bali Resort</h3>
                        <p><i class='bx bxs-map'></i> Bali</p>
                        <p class="price">Rp. 1.950.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/jefrinichol.png" alt="Jefri Nichol">
                                <span>Jefri Nichol</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Bali Resort">
                                <input type="hidden" name="location" value="Bali">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/Hotel bali resort.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Bali Resort", "location": "Bali", "price": "Rp. 1.950.000", "image": "Hotel bali resort.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 10 -->
                <div class="hotel-card">
                    <img src="images/HotelKempinski.jpg" alt="Hotel Kempinski" class="hotel-image"
                    data-description="Secara keseluruhan, Hotel Kempinski menawarkan pengalaman menginap yang mewah dan berkesan bagi para pelancong bisnis maupun wisatawan yang mencari kualitas, kenyamanan, dan standar pelayanan tertinggi. Mereka dikenal karena menjaga warisan kemewahan Eropa sambil terus berinovasi untuk memenuhi kebutuhan tamu modern.:

• Kamar & Suite:
- Desain Elegan
- Pemandangan Indah
- Kenyamanan Premium
- Suite Luas

• Fasilitas:
- Kempinski The Spa
- Pusat Kebugaran
- Kolam Renang
- Restoran & Bar Berkelas
- Grand Ballroom & Ruang Pertemuan
- Executive/Club Lounge (di beberapa properti)

• Layanan:
- Layanan Concierge Personal
- Layanan Kamar 24/7
- Layanan Tata Graha Profesional
- Layanan Transportasi
- Staf Berpengalaman"
                    data-images='["images/Kempinski-room1.jpg", "images/Kempinski-room2.jpg", "images/Kempinski-room3.jpg", "images/Kempinski-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Kempinski</h3>
                        <p><i class='bx bxs-map'></i> Jakarta Pusat</p>
                        <p class="price">Rp. 688.750/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/marcovanbasten.png" alt="Marco Van Basten">
                                <span>Marco Van Basten</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Kempinski">
                                <input type="hidden" name="location" value="Jakarta Pusat">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/HotelKempinski.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Kempinski", "location": "Jakarta Pusat", "price": "Rp. 688.750", "image": "Kempinski.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 11 -->
                <div class="hotel-card">
                    <img src="images/raffles.jpg" alt="Hotel Raffles" class="hotel-image"
                    data-description="Secara keseluruhan, Raffles Jakarta bukan sekadar tempat menginap, melainkan sebuah destinasi yang menawarkan perpaduan sempurna antara warisan seni, kemewahan abadi, dan layanan legendaris, menciptakan pengalaman yang mendalam dan tak terlupakan bagi setiap tamu yang mencari keunggulan di ibu kota.:

• Kamar & Suite:
- 173 kamar & suite mewah dengan pemandangan kota atau taman
- Raffles Suite dengan Raffles Butler pribadi
- Tempat tidur premium khas Raffles
- Sistem kontrol kamar modern (termasuk pencahayaan dan tirai)

• Fasilitas:
- Kolam renang luar ruangan dengan area bersantai di taman tropis
- Raffles Spa dengan berbagai ruang perawatan dan area relaksasi
- Pusat kebugaran lengkap dengan peralatan modern
- Berbagai pilihan kuliner: Arts Café by Raffles, The Writers Bar, Navina Pool Bar
- Club Lounge eksklusif (di beberapa properti atau untuk tamu suite tertentu)
- Dian Ballroom & ruang pertemuan serbaguna

• Layanan:
- Raffles Butler 24/7 yang personal dan intuitif
- Layanan mobil mewah & transportasi bandara
- Concierge service premium untuk segala kebutuhan
- Layanan tata graha harian
- Akses eksklusif ke fasilitas club (untuk tamu tertentu)"
                    data-images='["images/Raffles-room1.jpg", "images/Raffles-room2.jpg", "images/Raffles-room3.jpg", "images/Raffles-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Raffles</h3>
                        <p><i class='bx bxs-map'></i> Jakarta Selatan</p>
                        <p class="price">Rp. 4.750.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/jefrinichol.png" alt="Jefri Nichol">
                                <span>Jefri Nichol</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Raffles">
                                <input type="hidden" name="location" value="Jakarta Selatan">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/raffles.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Raffles", "location": "Jakarta Selatan", "price": "Rp. 4.750.000", "image": "raffles.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 12 -->
                <div class="hotel-card">
                    <img src="images/ritz-carlton.jpg" alt="The Ritz-Carlton" class="hotel-image"
                    data-description="The Ritz-Carlton Jakarta menawarkan kemewahan tertinggi:

• Kamar & Suite:
- 200+ kamar dengan pemandangan kota
- Ritz-Carlton suite dengan butler pribadi
- Tempat tidur Ritz-Carlton signature
- Smart home system

• Fasilitas:
- Sky pool dengan pemandangan 360°
- Spa dengan 15 ruang perawatan
- Fitness center dengan view kota
- 6 restoran bintang Michelin
- Club lounge eksklusif
- Grand ballroom

• Layanan:
- Personal butler 24/7
- Private jet & limousine service
- Concierge service premium
- Personal shopping & styling
- Exclusive club access"
                    data-images='["images/ritz-room1.jpg", "images/ritz-room2.jpg", "images/ritz-room3.jpg", "images/ritz-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>The Ritz-Carlton</h3>
                        <p><i class='bx bxs-map'></i> Jakarta</p>
                        <p class="price">Rp. 8.000.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/Jessica.png" alt="Jessica">
                                <span>Jessica</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="The Ritz-Carlton">
                                <input type="hidden" name="location" value="Jakarta">
                                <input type="hidden" name="price" value="8000000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/ritz-carlton.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "The Ritz-Carlton", "location": "Jakarta", "price": "Rp. 8.000.000", "image": "ritz-carlton.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 13 -->
                <div class="hotel-card">
                    <img src="images/royal-ambarukmo.jpg" alt="royal-ambarukmo" class="hotel-image"
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
                    data-images='["images/ambarrukmo-room1.jpg", "images/ambarrukmo-room2.jpg", "images/ambarrukmo-room3.jpg", "images/ambarrukmo-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Royal Ambarukmo</h3>
                        <p><i class='bx bxs-map'></i> Yogyakarta</p>
                        <p class="price">Rp. 1.588.755/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/robert.png" alt="Robert">
                                <span>Robert</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Royal Ambarukmo">
                                <input type="hidden" name="location" value="Yogyakarta">
                                <input type="hidden" name="price" value="1588755">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/ritz-carlton.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Royal Ambarukmo", "location": "Yogyakarta", "price": "Rp. 1.588.755", "image": "royal-ambarukmo.jpg", "rating": "4.9"}'>
                                <i class="bx bx-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- Hotel Card 14 -->
                <div class="hotel-card">
                    <img src="images/HotelFave.jpg" alt="hotel-fave" class="hotel-image"
                    data-description="Favehotel Malang adalah hotel bintang 3 yang terletak di kawasan perbelanjaan di Malang:

• Fasilitas Populer:
 - WiFi gratis
 - Parkir mandiri gratis
 - Resepsionis 24 jam
 - Restoran (Lime Restaurant, buka 06.00-22.00, menyajikan sarapan prasmanan dan menu à la carte Indonesia serta Barat)
 - Layanan kamar (jam tertentu)
 - Fasilitas laundry
 - Penitipan bagasi
 - Ruang rapat (Telogomas Meeting Room dengan berbagai ukuran)
 - Kamar bebas rokok
 - AC di setiap kamar
 - Brankas di kamar
 - Meja tulis
 - Televisi LCD dengan saluran kabel
 - Kamar mandi pribadi dengan shower dan perlengkapan mandi gratis
 - Pembersihan kamar harian

• Tipe Kamar:
- Superior Room
- Deluxe Room
- Deluxe Premier Room
- Deluxe Family Room"
                    data-images='["images/Fave Malang-room1.jpg", "images/Fave Malang-room2.jpg", "images/Fave Malang-room3.jpg", "images/Fave Malang-room4.jpg"]'>
                    <div class="rating">4.9 <i class='bx bxs-star'></i></div>
                    <div class="card-content">
                        <h3>Hotel Fave Malang</h3>
                        <p><i class='bx bxs-map'></i> Malang</p>
                        <p class="price">Rp. 504.000/Night</p>
                        <div class="profile-and-button">
                            <div class="profile">
                                <img src="images/marcovanbasten.png" alt="Marco Van Basten">
                                <span>Marco Van Basten</span>
                            </div>
                            <form action="booking_properties.php" method="POST">
                                <input type="hidden" name="hotel_name" value="Hotel Fave Malang">
                                <input type="hidden" name="location" value="Malang">
                                <input type="hidden" name="price" value="504000">
                                <input type="hidden" name="rating" value="4.9">
                                <input type="hidden" name="image" value="images/ritz-carlton.jpg">
                                <button type="submit" class="pesan-kamar-btn">Pesan Kamar</button>
                            </form>
                            <button class="add-to-cart-btn" 
                                data-hotel='{"name": "Hotel Fave Malang", "location": "Malang", "price": "Rp. 504.000", "image": "HotelFave.jpg", "rating": "4.9"}'>
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
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 id="modalHotelName"></h2>
            <p id="modalHotelLocation"></p>
            <div class="hotel-details">
                <div class="hotel-info">
                    <h3>Deskripsi Hotel</h3>
                    <p id="modalHotelDescription"></p>
                </div>
                <div class="room-gallery" id="modalRoomGallery">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get modal elements
        const modal = document.getElementById('hotelModal');
        const modalHotelName = document.getElementById('modalHotelName');
        const modalHotelLocation = document.getElementById('modalHotelLocation');
        const modalHotelDescription = document.getElementById('modalHotelDescription');
        const modalRoomGallery = document.getElementById('modalRoomGallery');
        const closeModalBtn = document.querySelector('.close-modal');

        function showHotelDetails(name, location, description, roomImages) {
            // Set modal content
            modalHotelName.textContent = name;
            modalHotelLocation.textContent = location;

            // Format description with proper line breaks
            const formattedDescription = description.replace(/\n/g, '<br>');
            modalHotelDescription.innerHTML = formattedDescription;

            // Clear previous images
            modalRoomGallery.innerHTML = '';

            // Add new images
            roomImages.forEach(imageSrc => {
                const img = document.createElement('img');
                img.src = imageSrc;
                img.alt = `${name} Room`;
                img.onerror = function() {
                    this.src = 'images/placeholder.jpg'; // Fallback image if the original fails to load
                };
                modalRoomGallery.appendChild(img);
            });

            // Show modal
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }

        // Close modal when clicking the close button
        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        // Close modal when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.style.display === 'block') {
                closeModal();
            }
        });

        // Add click event listeners to all hotel images
        document.querySelectorAll('.hotel-image').forEach(img => {
            img.addEventListener('click', function() {
                const hotelCard = this.closest('.hotel-card');
                const name = hotelCard.querySelector('h3').textContent;
                const location = hotelCard.querySelector('p').textContent.replace('📍 ', '');
                const description = this.getAttribute('data-description');
                const roomImages = JSON.parse(this.getAttribute('data-images'));

                showHotelDetails(name, location, description, roomImages);
            });
        });

        // Add event handler for login button
        document.querySelector('.login-btn').addEventListener('click', function() {
            window.location.href = 'login.php';
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
    </script>
</body>
</html>
