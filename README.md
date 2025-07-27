# 🌐 PemesananHotel
**Sistem Pemesanan Hotel Lengkap**  
*Versi: 2.0.0+ | Terakhir Diperbarui: Juli 2025 | Status: Production Ready*

## 🚀 Deskripsi
PemesananHotel adalah aplikasi web booking hotel dengan fitur lengkap mulai dari pencarian hotel, manajemen pesanan, hingga dashboard admin dan agen. Mendukung multi-peran (User, Agent, Admin) dan responsif.

---

## 🧩 Fitur Utama

### 🔍 Pencarian & Pemesanan Hotel
- Cari hotel berdasar lokasi, rating, dan fasilitas.
- Konfirmasi pemesanan dengan harga otomatis.
- **Utama:** `index.php`, `layanan.php`, `properties.php`.

### 🛒 Keranjang & Checkout
- Tambahkan hotel untuk dipesan nanti, checkout mudah.
- **Utama:** `cart.php`, `payment.php`.

### 💳 Pembayaran
- Metode: VA (BCA), QRIS, COD.
- **Utama:** `payment.php`.

### 🔐 Manajemen Akun & Keamanan
- Registrasi, login, ganti password.
- **Utama:** `Register.php`, `login.php`.

### 📊 Dashboard Admin & Agen
- Statistik hotel, kamar, dan pesanan.
- **Utama:** `admin_dashboard.php`, `agent_dashboard.php`.

### 🏨 Manajemen Hotel & Kamar
- Kelola hotel dan kamar, upload foto.
- **Utama:** `admin_properties.php`.

---

## 🔗 Alur Penggunaan
1. **Pencarian Hotel** → 2. **Tambah ke Keranjang** → 3. **Checkout** → 4. **Pilih Pembayaran** → 5. **Konfirmasi Pesanan**

---

## 🛠️ Teknologi
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Backend:** PHP 7.4+
- **Styling:** Bootstrap 5, Font Awesome
- **Font:** Google Fonts (Poppins)

---

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 atau lebih tinggi
- Web server (Apache/Nginx)
- MySQL/MariaDB (optional)

### Installation
```bash
# Clone repository
git clone https://github.com/whympxx/UnggulBookingHotel.git

# Masuk ke direktori project
cd UnggulBookingHotel

# Jalankan di localhost
php -S localhost:8000
```

### Demo
🌐 [Live Demo](https://your-demo-url.com) | 📺 [Video Demo](https://your-video-url.com)

---

## 📂 Struktur File

### 🏗️ Feature-Sliced Design (FSD) Architecture
**Proyek ini telah diimplementasikan dengan arsitektur FSD untuk meningkatkan maintainability dan scalability.**

```
src/
├── app/                    # 🎯 Application Layer
│   ├── index.php          # Main entry point
│   └── providers/         # App-level providers
│       ├── routing.php    # Routing logic
│       ├── database.php   # Database operations
│       └── auth.php       # Authentication
│
├── shared/                # 🔄 Shared Layer
│   ├── ui/components/     # Reusable UI components
│   └── lib/utils.php      # Common utilities
│
├── features/             # ✨ Features Layer
│   ├── hotel-booking/    # ✅ Hotel booking feature
│   ├── user-management/  # 🚧 User management
│   ├── admin-dashboard/  # 🚧 Admin dashboard
│   ├── agent-management/ # 🚧 Agent management
│   └── payment-processing/ # 🚧 Payment processing
│
└── entities/             # 📊 Business entities
```

### 📋 Legacy Files (Backward Compatibility)
```
PemesananHotel/
├── 🏠 index.php              # Halaman utama (Legacy)
├── 🛒 cart.php               # Keranjang belanja
├── 💳 payment.php            # Halaman pembayaran
├── 📊 admin_dashboard.php    # Dashboard admin
├── 🏨 properties.php         # Daftar hotel
├── 👤 Register.php           # Registrasi user
├── 🔐 login.php              # Login sistem
├── 📱 contact_admin.php      # Kontak admin
├── ⚙️ settings.php           # Pengaturan
├── 📁 images/                # Folder gambar
└── 🎨 *.css                  # File styling
```

---

## 🎯 Fitur Unggulan

| Fitur | Status | Deskripsi |
|-------|--------|----------|
| 🔍 Pencarian Real-time | ✅ | Pencarian hotel dengan filter lokasi & rating |
| 🛒 Keranjang Smart | ✅ | Simpan hotel favorit untuk dipesan nanti |
| 💳 Multi Payment | ✅ | VA BCA, QRIS, COD |
| 📊 Dashboard Analytics | ✅ | Statistik lengkap untuk admin & agen |
| 📱 Mobile Responsive | ✅ | Optimized untuk semua perangkat |
| 🔐 Security First | ✅ | XSS & CSRF protection |

---

## 👥 User Roles

### 🧑‍💼 Admin
- ✅ Kelola semua hotel & kamar
- ✅ Manajemen agen & user
- ✅ Laporan & analytics
- ✅ Website settings

### 🏨 Agent
- ✅ Kelola hotel milik sendiri
- ✅ Statistik pemesanan
- ✅ Laporan pendapatan

### 👤 User
- ✅ Cari & pesan hotel
- ✅ Kelola keranjang
- ✅ Riwayat pemesanan
- ✅ Profil management

---

## 📱 Responsivitas & Keamanan

### 📱 Responsive Design
- ✅ Desktop (1920px+)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile (320px - 767px)

### 🔐 Security Features
- ✅ XSS Protection
- ✅ CSRF Protection
- ✅ Input Validation
- ✅ File Upload Security
- ✅ SQL Injection Prevention

---

## 📊 Statistics

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue?style=for-the-badge&logo=php)
![CSS](https://img.shields.io/badge/CSS-3-blue?style=for-the-badge&logo=css3)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-yellow?style=for-the-badge&logo=javascript)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap)

---

## 🏗️ Feature-Sliced Design (FSD)

### 🌟 Arsitektur Modern
Proyek ini menggunakan **Feature-Sliced Design (FSD)**, metodologi arsitektur yang:
- 📦 **Modular**: Setiap fitur terisolasi dan independen
- 🔧 **Maintainable**: Kode terorganisir berdasarkan domain bisnis
- 📈 **Scalable**: Mudah menambah fitur dan developer baru
- 🧪 **Testable**: Setiap layer dapat ditest secara independen

### 📚 Dokumentasi FSD
📖 **[Baca dokumentasi lengkap FSD](FSD_ARCHITECTURE.md)**

### ✅ Fitur yang Telah Diimplementasi dengan FSD:
- **Hotel Booking**: Pencarian, filtering, dan manajemen hotel
- **Shared Components**: Header, navigation, dan utilities
- **Authentication**: Login, register, dan manajemen sesi
- **Routing System**: Clean URL routing dengan parameter support

### 🚧 Roadmap FSD:
- [ ] User Management Feature
- [ ] Admin Dashboard Feature  
- [ ] Agent Management Feature
- [ ] Payment Processing Feature
- [ ] API Layer Implementation
- [ ] Unit Testing Framework

---

## 🤝 Contributing

Kontribusi sangat diterima! Silakan:

1. 🍴 Fork repository
2. 🌱 Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push to branch (`git push origin feature/AmazingFeature`)
5. 🔄 Open Pull Request

---

## 📄 Lisensi
Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail.

## 🆘 Support

**Butuh bantuan?** Hubungi kami:
- 📧 Email: support@pemesananhotel.com
- 💬 Discord: [Join Server](https://discord.gg/your-server)
- 🐛 Issues: [GitHub Issues](https://github.com/whympxx/UnggulBookingHotel/issues)

---

## ⭐ Show Your Support

Jika project ini membantu Anda, berikan ⭐ di GitHub!

---

**Made with ❤️ by [whympxx](https://github.com/whympxx)**

