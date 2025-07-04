<?php
// admin_dashboard.php
// Data hotel dan agent (copy dari agents.php)
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
        'image' => 'novotel.jpg',
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
        'image' => 'kempinski.jpg',
        'rating' => '4.9',
        'description' => 'Luxury 5-star hotel in central Jakarta',
        'facilities' => ['Luxury Spa', 'Rooftop Pool', 'Fine Dining', 'Executive Lounge']
    ],
    // More hotels can be added
];

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

// Hitung total otomatis
$totalProperty = count($hotels);
$totalAgent = count($agents);
$totalLocations = count(array_unique(array_map(function($h){ return trim($h['location']); }, $hotels)));
// Total All Hotel mengikuti jumlah hotel di properties.php
$totalAllHotel = 9; // Jumlah hotel di bagian All Hotels pada properties.php
// Total kamar: jumlah seluruh kamar dari data di admin_properties.php
$totalKamar = 36; // Total dari semua kamar hotel yang ada
// Total orders: dummy (0)
$ordersFile = 'orders_data.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$totalOrders = is_array($orders) ? count($orders) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Unggul Booking Hotel</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Cropper.js CDN -->
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <span class="sidebar-title">Menu Admin</span>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li class="active"><a href="admin_dashboard.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="has-submenu">
                        <span><i class="fa fa-building"></i> Property Selection <i class="fa fa-chevron-down submenu-arrow"></i></span>
                        <ul class="submenu">
                            <li><a href="location.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%">Location</a></li>
                            <li><a href="admin_properties.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%">Property</a></li>
                        </ul>
                    </li>
                    <li><a href="website_setting.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%"><i class="fa fa-cog"></i> Website Setting</a></li>
                    <li><a href="orders.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%"><i class="fa fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="admin_agents.php" style="color:inherit;text-decoration:none;display:block;width:100%;height:100%"><i class="fa fa-user"></i> Agent</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="main-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <img src="images/logo.png" alt="Logo" class="logo">
                    <span class="brand-title">Unggul Booking Hotel</span>
                </div>
                <img src="images/profil.jpg" alt="Admin Profile" id="admin-profile-img" style="width:44px;height:44px;object-fit:cover;border-radius:50%;border:2px solid #007bff;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-left:auto;cursor:pointer;">
            </header>
            <section class="dashboard-section">
                <h2>Dashboard</h2>
                <div class="dashboard-cards">
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/adminlocation_icon.png" alt="Locations" style="width:36px;height:36px;object-fit:cover;"></div>
                        <div class="card-info">
                            <span class="card-title">Total Locations</span>
                            <span class="card-value" id="loc-value"><?php echo $totalLocations; ?></span>
                            <canvas id="chart-locations" width="80" height="40"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/adminproperty_icon.png" alt="Property" style="width:36px;height:36px;object-fit:cover;"></div>
                        <div class="card-info">
                            <span class="card-title">Total Property</span>
                            <span class="card-value" id="prop-value"><?php echo $totalProperty; ?></span>
                            <canvas id="chart-property" width="80" height="40"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/adminorder_icon.png" alt="Orders" style="width:36px;height:36px;object-fit:cover;"></div>
                        <div class="card-info">
                            <span class="card-title">Total Orders</span>
                            <span class="card-value" id="orders-value"><?php echo $totalOrders; ?></span>
                            <canvas id="chart-orders" width="80" height="40"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/adminagent_icon.png" alt="Agent" style="width:36px;height:36px;object-fit:cover;border-radius:50%;"></div>
                        <div class="card-info">
                            <span class="card-title">Total Agent</span>
                            <span class="card-value" id="agent-value"><?php echo $totalAgent; ?></span>
                            <canvas id="chart-agent" width="80" height="40"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/AdminAllHotel_icon.png" alt="Locations" style="width:36px;height:36px;object-fit:cover;"></div>
                        <div class="card-info">
                            <span class="card-title">Total All Hotel</span>
                            <span class="card-value"><?php echo $totalAllHotel; ?></span>
                            <canvas style="display:none;"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon"><img src="images/adminkamar_icon.png" alt="Kamar" style="width:36px;height:36px;object-fit:cover;"></div>
                        <div class="card-info">
                            <span class="card-title">Total Kamar</span>
                            <span class="card-value" id="kamar-value"><?php echo $totalKamar; ?></span>
                            <canvas id="chart-kamar" width="80" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Grafik Kamar Tersedia/Dipakai per Hotel -->
                <div class="kamar-bar-container">
                    <h3>Grafik Kamar Tersedia & Dipakai per Hotel (Realtime)</h3>
                    <canvas id="chart-kamar-per-hotel" width="420" height="220"></canvas>
                </div>
                <!-- Grafik Jumlah Kamar Tersedia & Dipakai -->
                <div class="kamar-bar-container">
                    <h3>Grafik Jumlah Kamar Tersedia & Dipakai (Realtime)</h3>
                    <canvas id="chart-kamar-bar" width="360" height="180">Browser Anda tidak mendukung canvas.</canvas>
                    <div class="kamar-bar-labels">
                        <span class="tersedia">Tersedia: <span id="label-kamar-tersedia">0</span></span>
                        <span class="dipakai">Dipakai: <span id="label-kamar-dipakai">0</span></span>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- Back to Home Button -->
    <div style="width:100%;text-align:center;margin:30px 0 10px 0;">
        <a href="index.php" style="display:inline-block;padding:12px 32px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-size:1.1em;font-weight:600;box-shadow:0 2px 8px rgba(0,0,0,0.08);transition:background 0.2s;">Kembali ke Halaman Utama</a>
    </div>
    <!-- Chart.js Mini Graphs Script -->
    <script>
    window.onload = function() {
    // Data awal dari PHP (untuk inisialisasi)
    let locData = [<?php echo $totalLocations; ?>];
    let propData = [<?php echo $totalProperty; ?>];
    let ordersData = [<?php echo $totalOrders; ?>];
    let agentData = [<?php echo $totalAgent; ?>];
    let kamarData = [<?php echo $totalKamar; ?>];
    // Data untuk grafik kamar tersedia/dipakai
    let kamarTersedia = 0;
    let kamarDipakai = 0;

    function makeMiniChart(ctx, data, color) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array(data.length).fill(''),
                datasets: [{
                    data: data,
                    borderColor: color,
                    backgroundColor: 'rgba(0,0,0,0)',
                    pointRadius: 0,
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } },
                elements: { line: { borderJoinStyle: 'round' } },
                animation: false,
                responsive: false,
                maintainAspectRatio: false
            }
        });
    }

    // Inisialisasi chart
    const chartLoc = makeMiniChart(document.getElementById('chart-locations').getContext('2d'), locData, '#007bff');
    const chartProp = makeMiniChart(document.getElementById('chart-property').getContext('2d'), propData, '#28a745');
    const chartOrders = makeMiniChart(document.getElementById('chart-orders').getContext('2d'), ordersData, '#ffc107');
    const chartAgent = makeMiniChart(document.getElementById('chart-agent').getContext('2d'), agentData, '#dc3545');
    const chartKamar = makeMiniChart(document.getElementById('chart-kamar').getContext('2d'), kamarData, '#6f42c1');

    // Grafik batang kamar tersedia/dipakai
    const ctxBar = document.getElementById('chart-kamar-bar').getContext('2d');
    let kamarBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Tersedia', 'Dipakai'],
            datasets: [{
                label: 'Jumlah Kamar',
                data: [0, 0],
                backgroundColor: ['#28a745', '#dc3545'],
                borderRadius: 8,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { display: true },
                y: { display: true, beginAtZero: true, precision:0 }
            },
            responsive: false,
            maintainAspectRatio: false,
            animation: false
        }
    });

    // Grafik batang kamar tersedia/dipakai per hotel
    const ctxKamarPerHotel = document.getElementById('chart-kamar-per-hotel').getContext('2d');
    let kamarPerHotelChart = new Chart(ctxKamarPerHotel, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Tersedia',
                    data: [],
                    backgroundColor: '#28a745',
                    borderRadius: 8,
                },
                {
                    label: 'Dipakai',
                    data: [],
                    backgroundColor: '#dc3545',
                    borderRadius: 8,
                }
            ]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: {
                x: { display: true },
                y: { display: true, beginAtZero: true, precision:0 }
            },
            responsive: false,
            maintainAspectRatio: false,
            animation: false
        }
    });

    // Fungsi update data dari server
    function updateDashboardData() {
        fetch('admin_dashboard_data.php')
            .then(res => res.json())
            .then(data => {
                // Push data baru ke array
                locData.push(data.locations);
                propData.push(data.property);
                ordersData.push(data.orders);
                agentData.push(data.agent);
                kamarData.push(data.kamar);
                // Batasi data max 10
                if(locData.length > 10) locData.shift();
                if(propData.length > 10) propData.shift();
                if(ordersData.length > 10) ordersData.shift();
                if(agentData.length > 10) agentData.shift();
                if(kamarData.length > 10) kamarData.shift();
                // Update chart
                chartLoc.data.datasets[0].data = locData;
                chartLoc.update();
                chartProp.data.datasets[0].data = propData;
                chartProp.update();
                chartOrders.data.datasets[0].data = ordersData;
                chartOrders.update();
                chartAgent.data.datasets[0].data = agentData;
                chartAgent.update();
                chartKamar.data.datasets[0].data = kamarData;
                chartKamar.update();
                // Update value di card
                document.getElementById('loc-value').textContent = data.locations;
                document.getElementById('prop-value').textContent = data.property;
                document.getElementById('orders-value').textContent = data.orders;
                document.getElementById('agent-value').textContent = data.agent;
                document.getElementById('kamar-value').textContent = data.kamar;
                // Update grafik kamar tersedia/dipakai
                kamarTersedia = data.kamar_tersedia;
                kamarDipakai = data.kamar_dipakai;
                kamarBarChart.data.datasets[0].data = [kamarTersedia, kamarDipakai];
                kamarBarChart.update();
                // Update label jumlah di bawah chart
                document.getElementById('label-kamar-tersedia').textContent = kamarTersedia;
                document.getElementById('label-kamar-dipakai').textContent = kamarDipakai;
                // Update grafik kamar per hotel
                if (data.kamar_per_hotel) {
                    kamarPerHotelChart.data.labels = data.kamar_per_hotel.map(h => h.hotel);
                    kamarPerHotelChart.data.datasets[0].data = data.kamar_per_hotel.map(h => h.tersedia);
                    kamarPerHotelChart.data.datasets[1].data = data.kamar_per_hotel.map(h => h.dipakai);
                    kamarPerHotelChart.update();
                }
            });
    }

    // Polling setiap 2 detik
    setInterval(updateDashboardData, 2000);
    }
    </script>
    <!-- Modal Upload Profile -->
    <div id="profileModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:32px 24px 24px 24px;border-radius:10px;box-shadow:0 2px 16px rgba(0,0,0,0.15);min-width:320px;position:relative;">
        <span id="closeProfileModal" style="position:absolute;right:16px;top:10px;font-size:1.5em;cursor:pointer;">&times;</span>
        <h3 style="margin-bottom:18px;">Ubah Foto Profil Admin</h3>
        <form id="profileUploadForm" action="admin_upload_profile.php" method="POST" enctype="multipart/form-data">
          <input type="file" id="profileFileInput" name="profile_img" accept="image/*" required style="margin-bottom:16px;">
          <br>
          <div style="width:160px;height:160px;margin:0 auto 16px auto;display:flex;align-items:center;justify-content:center;">
            <img id="profilePreview" src="" alt="Preview" style="max-width:160px;max-height:160px;border-radius:50%;display:none;background:#f0f0f0;object-fit:cover;">
          </div>
          <button type="submit" id="uploadBtn" style="padding:8px 24px;background:#007bff;color:#fff;border:none;border-radius:5px;font-weight:600;">Upload</button>
        </form>
        <div id="profileUploadMsg" style="margin-top:10px;color:#28a745;font-weight:500;"></div>
      </div>
    </div>
    <script>
    // Modal logic
    const profileImg = document.getElementById('admin-profile-img');
    const profileModal = document.getElementById('profileModal');
    const closeProfileModal = document.getElementById('closeProfileModal');
    const profileUploadForm = document.getElementById('profileUploadForm');
    const profileUploadMsg = document.getElementById('profileUploadMsg');
    const profileFileInput = document.getElementById('profileFileInput');
    const profilePreview = document.getElementById('profilePreview');
    const uploadBtn = document.getElementById('uploadBtn');
    let cropper = null;

    profileImg.onclick = () => { profileModal.style.display = 'flex'; profileUploadMsg.textContent = ''; };
    closeProfileModal.onclick = () => { profileModal.style.display = 'none'; if(cropper) { cropper.destroy(); cropper = null; } profilePreview.style.display = 'none'; };
    window.onclick = (e) => { if(e.target === profileModal) { profileModal.style.display = 'none'; if(cropper) { cropper.destroy(); cropper = null; } profilePreview.style.display = 'none'; } };

    profileFileInput.onchange = function(e) {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(evt) {
        profilePreview.src = evt.target.result;
        profilePreview.style.display = 'block';
        if (cropper) cropper.destroy();
        cropper = new Cropper(profilePreview, {
          aspectRatio: 1,
          viewMode: 1,
          dragMode: 'move',
          background: false,
          autoCropArea: 1,
          responsive: true,
          guides: false,
          highlight: false,
          cropBoxResizable: true,
          cropBoxMovable: true,
          minCropBoxWidth: 80,
          minCropBoxHeight: 80,
          ready() {
            // Bulatkan crop box
            const cropBox = this.cropper.cropBox;
            cropBox.classList && cropBox.classList.add('cropper-circular');
          }
        });
      };
      reader.readAsDataURL(file);
    };

    profileUploadForm.onsubmit = function(e) {
      e.preventDefault();
      if (!cropper) {
        profileUploadMsg.textContent = 'Pilih dan crop gambar terlebih dahulu.';
        profileUploadMsg.style.color = '#dc3545';
        return;
      }
      uploadBtn.disabled = true;
      profileUploadMsg.textContent = 'Mengunggah...';
      cropper.getCroppedCanvas({ width: 320, height: 320, imageSmoothingQuality: 'high' }).toBlob(function(blob) {
        const formData = new FormData();
        formData.append('profile_img', blob, 'profile.jpg');
        fetch('admin_upload_profile.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          uploadBtn.disabled = false;
          if(data.success) {
            profileUploadMsg.textContent = 'Foto profil berhasil diubah!';
            profileUploadMsg.style.color = '#28a745';
            setTimeout(() => {
              profileModal.style.display = 'none';
              if(cropper) { cropper.destroy(); cropper = null; }
              profilePreview.style.display = 'none';
              // Paksa reload gambar profil (bypass cache)
              profileImg.src = 'images/profil.jpg?' + new Date().getTime();
            }, 1000);
          } else {
            profileUploadMsg.textContent = data.error || 'Gagal upload.';
            profileUploadMsg.style.color = '#dc3545';
          }
        })
        .catch(() => {
          uploadBtn.disabled = false;
          profileUploadMsg.textContent = 'Gagal upload.';
          profileUploadMsg.style.color = '#dc3545';
        });
      }, 'image/jpeg', 0.95);
    };
    </script>
    <style>
    /* Cropper bulat */
    .cropper-circular .cropper-view-box,
    .cropper-circular .cropper-face {
      border-radius: 50% !important;
    }
    </style>
</body>
</html> 