<?php
// agent_dashboard.php
session_start();

// Simulasi data untuk demo
$totalHotels = 12;
$totalBookings = 156;
$totalRevenue = 45000000;
$recentBookings = [
    ['hotel' => 'Hotel Santika', 'room' => 'Deluxe Room', 'guest' => 'John Doe', 'date' => '2024-01-15', 'status' => 'Confirmed'],
    ['hotel' => 'Hotel Continental', 'room' => 'Suite Room', 'guest' => 'Jane Smith', 'date' => '2024-01-14', 'status' => 'Pending'],
    ['hotel' => 'Hotel Kempinski', 'room' => 'Executive Suite', 'guest' => 'Mike Johnson', 'date' => '2024-01-13', 'status' => 'Confirmed']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Hotel Booking</title>
    <link rel="stylesheet" href="agent_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="agent-header">
        <div class="logo">
            <img src="images/logo.png" alt="Logo Hotel" onerror="this.style.display='none';this.nextElementSibling.style.display='inline-block';">
            <span class="logo-fallback" style="display:none;font-weight:bold;font-size:1.3rem;">Hotel</span>
            <span>Agent Dashboard</span>
        </div>
        <div class="header-actions">
            <div class="notification-bell" role="button" tabindex="0" aria-label="Notifikasi (3 pesan baru)">
                <i class="fas fa-bell" aria-hidden="true"></i>
                <span class="notification-badge" aria-label="3 notifikasi baru">3</span>
            </div>
            <div class="user-profile">
                <img src="images/profil.jpg" alt="Profile" class="profile-img">
                <span class="user-name">Agent Name</span>
            </div>
            <a href="user_selection.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#dashboard" class="sidebar-link active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="#add-hotel" class="sidebar-link">
                <i class="fas fa-hotel"></i> Tambah Hotel
            </a>
            <a href="#manage-hotels" class="sidebar-link">
                <i class="fas fa-building"></i> Kelola Hotel
            </a>
            <a href="#bookings" class="sidebar-link">
                <i class="fas fa-calendar-check"></i> Pemesanan
            </a>
            <a href="#reports" class="sidebar-link">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="#settings" class="sidebar-link">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Dashboard Overview -->
            <section id="dashboard" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-tachometer-alt"></i> Dashboard Overview</h2>
                    <p class="section-subtitle">Selamat datang kembali! Berikut adalah ringkasan aktivitas Anda hari ini.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $totalHotels; ?></h3>
                            <p>Total Hotel</p>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +12%
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $totalBookings; ?></h3>
                            <p>Total Pemesanan</p>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +8%
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Rp <?php echo number_format($totalRevenue, 0, ',', '.'); ?></h3>
                            <p>Total Pendapatan</p>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +15%
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>89%</h3>
                            <p>Kepuasan Pelanggan</p>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +5%
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="dashboard-grid">
                    <div class="recent-bookings">
                        <div class="card-header">
                            <h3><i class="fas fa-clock"></i> Pemesanan Terbaru</h3>
                            <a href="#bookings" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="bookings-list">
                            <?php foreach ($recentBookings as $booking): ?>
                            <div class="booking-item">
                                <div class="booking-info">
                                    <h4><?php echo $booking['hotel']; ?></h4>
                                    <p><?php echo $booking['room']; ?> - <?php echo $booking['guest']; ?></p>
                                    <span class="booking-date"><?php echo date('d M Y', strtotime($booking['date'])); ?></span>
                                </div>
                                <div class="booking-status <?php echo strtolower($booking['status']); ?>">
                                    <?php echo $booking['status']; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
                        </div>
                        <div class="actions-grid">
                                        <a href="#add-hotel" class="action-card" data-tooltip="Tambah hotel baru (Ctrl+N)">
                <i class="fas fa-plus"></i>
                <span>Tambah Hotel</span>
            </a>
            <a href="#bookings" class="action-card" data-tooltip="Kelola pemesanan">
                <i class="fas fa-calendar-plus"></i>
                <span>Riwayat Pesanan</span>
            </a>
            <a href="#reports" class="action-card" data-tooltip="Generate laporan">
                <i class="fas fa-file-alt"></i>
                <span>Generate Laporan</span>
            </a>
            <a href="#settings" class="action-card" data-tooltip="Pengaturan akun">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Add Hotel Section -->
            <section id="add-hotel" class="content-section" style="display:none;">
                <div class="section-header">
                    <h2><i class="fas fa-hotel"></i> Tambah Hotel Baru</h2>
                    <p class="section-subtitle">Lengkapi informasi hotel yang akan ditambahkan ke sistem.</p>
                </div>
                
                <div class="form-container">
                    <form class="add-hotel-form" id="addHotelForm" action="save_hotel.php" method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-building"></i> Nama Hotel</label>
                                <input type="text" name="hotel_name" placeholder="Masukkan nama hotel" required aria-describedby="hotel-name-help">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-map-marker-alt"></i> Lokasi</label>
                                <input type="text" name="location" placeholder="Masukkan lokasi hotel" required>
                            </div>
                            <div class="form-group full-width">
                                <label><i class="fas fa-align-left"></i> Deskripsi</label>
                                <textarea name="description" placeholder="Deskripsi hotel, fasilitas, dan informasi penting lainnya" required></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-star"></i> Rating</label>
                                <select name="rating" required>
                                    <option value="">Pilih rating</option>
                                    <option value="1">1 Bintang</option>
                                    <option value="2">2 Bintang</option>
                                    <option value="3">3 Bintang</option>
                                    <option value="4">4 Bintang</option>
                                    <option value="5">5 Bintang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Nomor Telepon</label>
                                <input type="tel" name="phone" placeholder="Nomor telepon hotel">
                            </div>
                            <div class="form-group full-width">
                                <label><i class="fas fa-image"></i> Gambar Hotel</label>
                                <div class="file-upload-container">
                                    <input type="file" name="hotel_image" accept="image/*" required id="hotelImage">
                                    <label for="hotelImage" class="file-upload-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Pilih gambar hotel</span>
                                        <small>Format: JPG, PNG, GIF (Max: 5MB)</small>
                                    </label>
                                </div>
                                <div id="imagePreview" class="image-preview" style="display:none;">
                                    <img src="" alt="Preview" id="previewImg">
                                    <button type="button" id="removeImage" class="remove-image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-primary" data-tooltip="Simpan hotel (Ctrl+S)">
                                <i class="fas fa-save"></i> Tambah Hotel
                            </button>
                        </div>
                    </form>
                </div>
                <div id="formMessage" class="form-message"></div>
            </section>

            <!-- Manage Hotels Section -->
            <section id="manage-hotels" class="content-section" style="display:none;">
                <div class="section-header">
                    <h2><i class="fas fa-building"></i> Kelola Hotel</h2>
                    <p class="section-subtitle">Kelola semua hotel yang telah Anda tambahkan.</p>
                </div>
                
                <div class="hotels-management">
                    <div class="search-filter">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Cari hotel..." id="searchHotel">
                        </div>
                        <div class="filter-options">
                            <select id="ratingFilter">
                                <option value="">Semua Rating</option>
                                <option value="5">5 Bintang</option>
                                <option value="4">4 Bintang</option>
                                <option value="3">3 Bintang</option>
                                <option value="2">2 Bintang</option>
                                <option value="1">1 Bintang</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="hotels-grid" id="hotelsGrid">
                        <!-- Hotel cards will be loaded here -->
                        <div class="empty-state">
                            <i class="fas fa-hotel"></i>
                            <h3>Belum ada hotel</h3>
                            <p>Mulai dengan menambahkan hotel pertama Anda.</p>
                            <a href="#add-hotel" class="btn-primary">Tambah Hotel</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Bookings Section -->
            <section id="bookings" class="content-section" style="display:none;">
                <div class="section-header">
                    <h2><i class="fas fa-calendar-check"></i> Riwayat Pesanan</h2>
                    <p class="section-subtitle">Kelola semua pemesanan hotel.</p>
                </div>
                
                <div class="bookings-management">
                    <div class="bookings-stats">
                        <div class="stat-item">
                            <span class="stat-number">45</span>
                            <span class="stat-label">Hari Ini</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">156</span>
                            <span class="stat-label">Bulan Ini</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1,234</span>
                            <span class="stat-label">Total</span>
                        </div>
                    </div>
                    
                    <div class="bookings-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Hotel</th>
                                    <th>Kamar</th>
                                    <th>Tamu</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hotel Santika</td>
                                    <td>Deluxe Room</td>
                                    <td>John Doe</td>
                                    <td>15 Jan 2024</td>
                                    <td>17 Jan 2024</td>
                                    <td><span class="status confirmed">Confirmed</span></td>
                                    <td>
                                        <button class="btn-action"><i class="fas fa-eye"></i></button>
                                        <button class="btn-action"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Reports Section -->
            <section id="reports" class="content-section" style="display:none;">
                <div class="section-header">
                    <h2><i class="fas fa-chart-bar"></i> Laporan</h2>
                    <p class="section-subtitle">Generate dan lihat laporan performa hotel.</p>
                </div>
                <div class="reports-container">
                    <div class="report-cards">
                        <div class="report-card">
                            <h3>Laporan Bulanan</h3>
                            <p>Ringkasan performa hotel bulan ini</p>
                            <button class="btn-primary" id="generateMonthlyReport">Generate</button>
                            <div id="monthlyReportResult" class="report-result"></div>
                        </div>
                        <div class="report-card">
                            <h3>Laporan Pendapatan</h3>
                            <p>Analisis pendapatan dan profit</p>
                            <button class="btn-primary" id="generateRevenueReport">Generate</button>
                            <div id="revenueReportResult" class="report-result"></div>
                        </div>
                        <div class="report-card">
                            <h3>Laporan Kepuasan</h3>
                            <p>Rating dan review pelanggan</p>
                            <button class="btn-primary" id="generateSatisfactionReport">Generate</button>
                            <div id="satisfactionReportResult" class="report-result"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="content-section" style="display:none;">
                <div class="section-header">
                    <h2><i class="fas fa-cog"></i> Pengaturan</h2>
                    <p class="section-subtitle">Kelola pengaturan akun dan preferensi.</p>
                </div>
                
                <div class="settings-container">
                    <div class="settings-card">
                        <h3>Profil Akun</h3>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" value="Agent Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="agent@example.com">
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" value="+62 812-3456-7890">
                            </div>
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                    
                    <div class="settings-card">
                        <h3>Notifikasi</h3>
                        <div class="notification-settings">
                            <div class="setting-item">
                                <label>Email Notifikasi</label>
                                <input type="checkbox" checked>
                            </div>
                            <div class="setting-item">
                                <label>Notifikasi Pemesanan</label>
                                <input type="checkbox" checked>
                            </div>
                            <div class="setting-item">
                                <label>Notifikasi Review</label>
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- MODAL: Lihat Hotel -->
    <div class="modal fade" id="viewHotelModal" tabindex="-1" aria-labelledby="viewHotelLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewHotelLabel">Detail Hotel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="viewHotelBody">
            <!-- Konten detail hotel akan diisi via JS -->
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL: Edit Hotel -->
    <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editHotelLabel">Edit Hotel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editHotelForm">
              <input type="hidden" name="id" id="editHotelId">
              <div class="mb-3">
                <label class="form-label">Nama Hotel</label>
                <input type="text" class="form-control" name="hotel_name" id="editHotelName" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="location" id="editHotelLocation" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" id="editHotelDescription" required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Rating</label>
                <select class="form-select" name="rating" id="editHotelRating" required>
                  <option value="">Pilih rating</option>
                  <option value="1">1 Bintang</option>
                  <option value="2">2 Bintang</option>
                  <option value="3">3 Bintang</option>
                  <option value="4">4 Bintang</option>
                  <option value="5">5 Bintang</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Gambar Hotel (kosongkan jika tidak ingin ganti)</label>
                <input type="file" class="form-control" name="hotel_image" id="editHotelImage" accept="image/*">
                <div id="editImagePreview" style="margin-top:10px;"></div>
              </div>
              <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
              <div id="editFormMessage" class="form-message"></div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Navigasi sidebar
        const links = document.querySelectorAll('.sidebar-link');
        const sections = document.querySelectorAll('.content-section');
        let activeIdx = localStorage.getItem('agentSidebarActiveIdx') || 0;

        function showSection(idx) {
            links.forEach(l => l.classList.remove('active'));
            links[idx].classList.add('active');
            sections.forEach(s => s.style.display = 'none');
            sections[idx].style.display = 'block';
            localStorage.setItem('agentSidebarActiveIdx', idx);
            
            // Load hotels data when manage-hotels section is shown
            if (idx === 2) { // Index for manage-hotels section
                setTimeout(() => {
                    loadHotels();
                }, 100);
            }
        }

        links.forEach((link, idx) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(idx);
            });
        });

        showSection(activeIdx);

        // Event listener untuk aksi cepat
        document.querySelectorAll('.action-card').forEach(action => {
            action.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href === '#add-hotel') showSection(1);
                else if (href === '#bookings') showSection(3);
                else if (href === '#reports') showSection(4);
                else if (href === '#settings') showSection(5);
            });
        });

        // File upload preview
        const fileInput = document.getElementById('hotelImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeImage = document.getElementById('removeImage');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        removeImage.addEventListener('click', function() {
            fileInput.value = '';
            imagePreview.style.display = 'none';
        });

        // Form validation and submission
        const addHotelForm = document.getElementById('addHotelForm');
        const formMessage = document.getElementById('formMessage');

        addHotelForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi form
            const formData = new FormData(addHotelForm);
            const hotelName = formData.get('hotel_name').trim();
            const location = formData.get('location').trim();
            const description = formData.get('description').trim();
            const rating = formData.get('rating');
            const hotelImage = formData.get('hotel_image');
            
            if (!hotelName || !location || !description || !rating) {
                showMessage('Semua field wajib diisi', 'error');
                return;
            }
            
            if (!hotelImage || hotelImage.size === 0) {
                showMessage('Gambar hotel wajib diupload', 'error');
                return;
            }
            
            // Show loading
            showMessage('<i class="fas fa-spinner fa-spin"></i> Mengirim data...', 'loading');

            // Submit form dengan AJAX
            fetch('save_hotel.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('<i class="fas fa-check-circle"></i> ' + data.message, 'success');
                    addHotelForm.reset();
                    imagePreview.style.display = 'none';
                    
                    // Refresh dashboard stats jika di halaman dashboard
                    if (document.querySelector('#dashboard').style.display !== 'none') {
                        // Update stats (simulasi)
                        updateDashboardStats();
                    }
                } else {
                    showMessage('<i class="fas fa-exclamation-circle"></i> ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan saat mengirim data', 'error');
            });
        });

        function showMessage(message, type) {
            formMessage.style.display = 'block';
            formMessage.className = `form-message ${type}`;
            formMessage.innerHTML = message;
            
            if (type === 'success') {
                setTimeout(() => {
                    formMessage.style.display = 'none';
                }, 5000);
            }
        }

        function updateDashboardStats() {
            // Simulasi update stats
            const statNumbers = document.querySelectorAll('.stat-content h3');
            statNumbers[0].textContent = parseInt(statNumbers[0].textContent) + 1;
        }

        function resetForm() {
            addHotelForm.reset();
            imagePreview.style.display = 'none';
            previewImg.src = '';
            formMessage.style.display = 'none';
        }

        // Search functionality
        const searchInput = document.getElementById('searchHotel');
        const ratingFilter = document.getElementById('ratingFilter');
        const hotelsGrid = document.getElementById('hotelsGrid');
        
        // Load hotels on page load (only if manage-hotels section is visible)
        if (document.querySelector('#manage-hotels').style.display !== 'none') {
            loadHotels();
        }
        
        searchInput.addEventListener('input', function(e) {
            loadHotels();
        });
        
        ratingFilter.addEventListener('change', function(e) {
            loadHotels();
        });
        
        function loadHotels() {
            const searchTerm = searchInput.value;
            const rating = ratingFilter.value;
            hotelsGrid.innerHTML = '<div class="loading">Loading...</div>';
            fetch(`get_hotels.php?search=${encodeURIComponent(searchTerm)}&rating=${encodeURIComponent(rating)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        displayHotels(data.data);
                    } else {
                        hotelsGrid.innerHTML = '<div class="error">Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hotelsGrid.innerHTML = '<div class="error">Terjadi kesalahan saat memuat data</div>';
                });
        }
        
        function displayHotels(hotels) {
            if (hotels.length === 0) {
                hotelsGrid.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-hotel"></i>
                        <h3>Tidak ada hotel ditemukan</h3>
                        <p>Coba ubah filter pencarian Anda.</p>
                    </div>
                `;
                return;
            }
            
            const hotelsHTML = hotels.map(hotel => `
                <div class="hotel-card">
                    <div class="hotel-image">
                        <img src="${hotel.image}" alt="${hotel.name}" onerror="this.src='images/default-hotel.jpg'">
                        <div class="hotel-rating">
                            ${'★'.repeat(hotel.rating)}${'☆'.repeat(5-hotel.rating)}
                        </div>
                    </div>
                    <div class="hotel-info">
                        <h3>${hotel.name}</h3>
                        <p><i class="fas fa-map-marker-alt"></i> ${hotel.location}</p>
                        <p class="hotel-description">${hotel.description.substring(0, 100)}${hotel.description.length > 100 ? '...' : ''}</p>
                        <div class="hotel-actions">
                            <button class="btn-action" onclick="editHotel('${hotel.id}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-action" onclick="viewHotel('${hotel.id}')">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                            <button class="btn-action delete" onclick="deleteHotel('${hotel.id}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            hotelsGrid.innerHTML = hotelsHTML;
        }
        
        function editHotel(hotelId) {
            fetch(`get_hotels.php?id=${encodeURIComponent(hotelId)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        const hotel = data.data;
                        document.getElementById('editHotelId').value = hotel.id;
                        document.getElementById('editHotelName').value = hotel.name;
                        document.getElementById('editHotelLocation').value = hotel.location;
                        document.getElementById('editHotelDescription').value = hotel.description;
                        document.getElementById('editHotelRating').value = hotel.rating;
                        // Preview gambar lama
                        let imgHtml = hotel.image ? `<img src="${hotel.image}" alt="Preview" style="max-width:120px;max-height:80px;">` : '';
                        document.getElementById('editImagePreview').innerHTML = imgHtml;
                        document.getElementById('editFormMessage').innerHTML = '';
                        new bootstrap.Modal(document.getElementById('editHotelModal')).show();
                    } else {
                        alert('Gagal mengambil data hotel.');
                    }
                })
                .catch(() => alert('Gagal mengambil data hotel.'));
        }
        
        function viewHotel(hotelId) {
            fetch(`get_hotels.php?id=${encodeURIComponent(hotelId)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        const hotel = data.data;
                        document.getElementById('viewHotelBody').innerHTML = `
                            <div class="row">
                                <div class="col-md-5"><img src="${hotel.image}" alt="${hotel.name}" style="width:100%;max-height:200px;object-fit:cover;"></div>
                                <div class="col-md-7">
                                    <h4>${hotel.name}</h4>
                                    <p><b>Lokasi:</b> ${hotel.location}</p>
                                    <p><b>Deskripsi:</b> ${hotel.description}</p>
                                    <p><b>Rating:</b> ${'★'.repeat(hotel.rating)}${'☆'.repeat(5-hotel.rating)}</p>
                                </div>
                            </div>
                        `;
                        new bootstrap.Modal(document.getElementById('viewHotelModal')).show();
                    } else {
                        document.getElementById('viewHotelBody').innerHTML = '<div class="error">Gagal mengambil data hotel.</div>';
                        new bootstrap.Modal(document.getElementById('viewHotelModal')).show();
                    }
                })
                .catch(() => {
                    document.getElementById('viewHotelBody').innerHTML = '<div class="error">Gagal mengambil data hotel.</div>';
                    new bootstrap.Modal(document.getElementById('viewHotelModal')).show();
                });
        }
        
        function deleteHotel(hotelId) {
            if (confirm('Apakah Anda yakin ingin menghapus hotel ini?')) {
                // Implementasi delete hotel dengan AJAX
                fetch('delete_hotel.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(hotelId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('<i class="fas fa-check-circle"></i> ' + data.message, 'success');
                        loadHotels();
                    } else {
                        showMessage('<i class="fas fa-exclamation-circle"></i> ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan saat menghapus hotel', 'error');
                });
            }
        }

        // Notification bell click
        const notificationBell = document.querySelector('.notification-bell');
        notificationBell.addEventListener('click', function() {
            alert('Notifikasi:\n- 3 pemesanan baru\n- 2 review baru\n- 1 pembayaran pending');
        });

        // Auto-hide success message
        if (window.location.search.includes('success=1')) {
            formMessage.style.display = 'block';
            formMessage.className = 'form-message success';
            formMessage.innerHTML = '<i class="fas fa-check-circle"></i> Hotel berhasil ditambahkan!';
            
            setTimeout(() => {
                formMessage.style.display = 'none';
            }, 5000);
        }

        // Add smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation for page transitions
        function showPageLoading() {
            const loading = document.createElement('div');
            loading.className = 'page-loading';
            loading.innerHTML = '<div class="spinner"></div>';
            document.body.appendChild(loading);
        }

        function hidePageLoading() {
            const loading = document.querySelector('.page-loading');
            if (loading) {
                loading.remove();
            }
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + N untuk tambah hotel baru
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                showSection(1); // Index untuk section add-hotel
            }
            
            // Ctrl/Cmd + S untuk save (jika di form)
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const activeSection = document.querySelector('.content-section[style*="block"]');
                if (activeSection && activeSection.id === 'add-hotel') {
                    addHotelForm.dispatchEvent(new Event('submit'));
                }
            }
        });

        // Add tooltips
        function addTooltips() {
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    document.body.appendChild(tooltip);
                    
                    const rect = this.getBoundingClientRect();
                    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
                    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
                });
                
                element.addEventListener('mouseleave', function() {
                    const tooltip = document.querySelector('.tooltip');
                    if (tooltip) {
                        tooltip.remove();
                    }
                });
            });
        }

        // Initialize tooltips
        addTooltips();

        // Navigasi sidebar - pastikan konsisten setelah reload
        document.addEventListener('DOMContentLoaded', function() {
            showSection(activeIdx);
        });

        // === Laporan Section ===
        const monthlyBtn = document.getElementById('generateMonthlyReport');
        const revenueBtn = document.getElementById('generateRevenueReport');
        const satisfactionBtn = document.getElementById('generateSatisfactionReport');
        const monthlyResult = document.getElementById('monthlyReportResult');
        const revenueResult = document.getElementById('revenueReportResult');
        const satisfactionResult = document.getElementById('satisfactionReportResult');

        // Helper: Reset all report results
        function resetReportResults() {
            monthlyResult.innerHTML = '';
            revenueResult.innerHTML = '';
            satisfactionResult.innerHTML = '';
        }

        monthlyBtn.addEventListener('click', function() {
            resetReportResults();
            monthlyResult.innerHTML = '<div class="loading" style="margin: 1rem 0;">Loading...</div>';
            fetch('orders_data.json')
                .then(res => res.json())
                .then(data => {
                    // Filter data bulan ini
                    const now = new Date();
                    const month = now.getMonth() + 1;
                    const year = now.getFullYear();
                    const orders = data.filter(order => {
                        const d = new Date(order.checkin);
                        return d.getMonth() + 1 === month && d.getFullYear() === year;
                    });
                    if (orders.length === 0) {
                        monthlyResult.innerHTML = '<div class="info" style="margin: 1rem 0;">Belum ada pemesanan di bulan ini.</div>';
                        return;
                    }
                    const totalOrders = orders.length;
                    let totalRevenue = 0;
                    const hotelCount = {};
                    orders.forEach(order => {
                        let val = 0;
                        if (typeof order.total === 'string') {
                            val = parseInt(order.total.replace(/[^0-9]/g, ''));
                        } else if (typeof order.total === 'number') {
                            val = order.total;
                        }
                        totalRevenue += val;
                        hotelCount[order.hotel] = (hotelCount[order.hotel] || 0) + 1;
                    });
                    // Hotel terpopuler
                    let topHotel = '-';
                    let maxBook = 0;
                    for (const h in hotelCount) {
                        if (hotelCount[h] > maxBook) {
                            maxBook = hotelCount[h];
                            topHotel = h;
                        }
                    }
                    // Tabel ringkasan
                    monthlyResult.innerHTML = `
                        <table class="table table-bordered table-striped mt-3 mb-3">
                            <tr><th>Total Pemesanan</th><td>${totalOrders}</td></tr>
                            <tr><th>Total Pendapatan</th><td>Rp ${totalRevenue.toLocaleString('id-ID')}</td></tr>
                            <tr><th>Hotel Terpopuler</th><td>${topHotel}</td></tr>
                        </table>
                    `;
                })
                .catch(() => {
                    monthlyResult.innerHTML = '<div class="error" style="margin: 1rem 0;">Gagal mengambil data laporan.</div>';
                });
        });

        revenueBtn.addEventListener('click', function() {
            resetReportResults();
            revenueResult.innerHTML = '<div class="loading" style="margin: 1rem 0;">Loading...</div>';
            fetch('orders_data.json')
                .then(res => res.json())
                .then(data => {
                    // Hitung pendapatan per hotel
                    const revenuePerHotel = {};
                    data.forEach(order => {
                        let val = 0;
                        if (typeof order.total === 'string') {
                            val = parseInt(order.total.replace(/[^0-9]/g, ''));
                        } else if (typeof order.total === 'number') {
                            val = order.total;
                        }
                        revenuePerHotel[order.hotel] = (revenuePerHotel[order.hotel] || 0) + val;
                    });
                    const hotelNames = Object.keys(revenuePerHotel);
                    if (hotelNames.length === 0) {
                        revenueResult.innerHTML = '<div class="info" style="margin: 1rem 0;">Belum ada data pendapatan hotel.</div>';
                        return;
                    }
                    // Tabel pendapatan
                    let table = '<table class="table table-bordered table-striped mt-3 mb-3"><thead><tr><th>Hotel</th><th>Pendapatan</th></tr></thead><tbody>';
                    for (const h in revenuePerHotel) {
                        table += `<tr><td>${h}</td><td>Rp ${revenuePerHotel[h].toLocaleString('id-ID')}</td></tr>`;
                    }
                    table += '</tbody></table>';
                    // Grafik pendapatan
                    const chartId = 'revenueChart';
                    revenueResult.innerHTML = table + `<canvas id="${chartId}" height="220" style="margin-bottom:1rem;"></canvas>`;
                    // Render Chart.js jika data ada
                    setTimeout(() => {
                        if (hotelNames.length > 0) {
                            const ctx = document.getElementById(chartId).getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: hotelNames,
                                    datasets: [{
                                        label: 'Pendapatan',
                                        data: hotelNames.map(h => revenuePerHotel[h]),
                                        backgroundColor: 'rgba(102,126,234,0.7)',
                                        borderColor: 'rgba(102,126,234,1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { display: false } },
                                    scales: { y: { beginAtZero: true } }
                                }
                            });
                        }
                    }, 200);
                })
                .catch(() => {
                    revenueResult.innerHTML = '<div class="error" style="margin: 1rem 0;">Gagal mengambil data laporan.</div>';
                });
        });

        satisfactionBtn.addEventListener('click', function() {
            resetReportResults();
            satisfactionResult.innerHTML = '<div class="info" style="margin: 1rem 0;">Belum ada data rating & review pelanggan. Fitur ini akan segera tersedia.<br><small>Hubungi admin jika ingin mengaktifkan fitur ini lebih awal.</small></div>';
        });

        // Submit Edit Hotel
        const editHotelForm = document.getElementById('editHotelForm');
        if (editHotelForm) {
            editHotelForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(editHotelForm);
                document.getElementById('editFormMessage').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                fetch('update_hotel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('editFormMessage').innerHTML = '<span class="success">' + data.message + '</span>';
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('editHotelModal')).hide();
                            loadHotels();
                        }, 1200);
                    } else {
                        document.getElementById('editFormMessage').innerHTML = '<span class="error">' + data.message + '</span>';
                    }
                })
                .catch(() => {
                    document.getElementById('editFormMessage').innerHTML = '<span class="error">Gagal menyimpan perubahan.</span>';
                });
            });
        }
    </script>
</body>
</html> 