# PemesananHotel - Sistem Pemesanan Hotel Lengkap

## Deskripsi
PemesananHotel adalah aplikasi web untuk pemesanan hotel yang menyediakan fitur lengkap mulai dari pencarian hotel, manajemen pesanan, pembayaran, hingga dashboard admin dan agen. Sistem ini mendukung multi-peran (User, Agent, Admin) dan dirancang responsif serta aman.

---

## Fitur Lengkap

### 1. Pencarian & Pemesanan Hotel
- Cari hotel berdasarkan lokasi, rating, dan fasilitas.
- Lihat detail hotel, harga, galeri foto, dan fasilitas.
- Form pemesanan dengan pilihan tanggal, tipe kamar, jumlah tamu, dan permintaan khusus.
- Konfirmasi pemesanan dan perhitungan harga otomatis.
- **File utama:** `index.php`, `layanan.php`, `properties.php`, `booking.php`, `booking_properties.php`, `search_hotels.php`

### 2. Keranjang & Checkout
- Tambahkan hotel ke keranjang (cart) untuk dipesan nanti.
- Checkout satuan atau sekaligus semua hotel di keranjang.
- Ringkasan keranjang dan total harga.
- **File utama:** `cart.php`, `cart.css`, `payment.php`, `save_order.php`

### 3. Pembayaran
- Pilihan metode pembayaran: Virtual Account (BCA), QRIS, dan Bayar di Tempat (COD).
- Halaman kode pembayaran (VA/QRIS/COD) dengan instruksi dan timer.
- Konfirmasi pembayaran dan status pesanan.
- **File utama:** `payment.php`, `va_code.php`, `va_code.css`

### 4. Manajemen Akun & Keamanan
- Registrasi, login, dan logout untuk user, agent, dan admin.
- Edit profil, ganti password, dan pengaturan keamanan akun.
- Pengaturan bahasa dan preferensi user.
- **File utama:** `Register.php`, `login.php`, `agent_register.php`, `agent_login.php`, `admin_register.php`, `admin_login.php`, `profile.php`, `account_security.php`, `change_password.php`, `ganti_password.php`, `language_settings.php`, `settings.php`

### 5. Dashboard Admin & Agen
- **Admin Dashboard:** Statistik hotel, kamar, lokasi, agent, dan pesanan.
- **Agent Dashboard:** Statistik hotel, pemesanan, pendapatan, dan kepuasan pelanggan.
- Kelola data hotel, kamar, agent, dan pesanan.
- Grafik dan laporan performa (bulanan, pendapatan, kepuasan).
- **File utama:** `admin_dashboard.php`, `admin_dashboard.css`, `admin_agents.php`, `admin_properties.php`, `admin_dashboard_data.php`, `agent_dashboard.php`, `agent_dashboard.css`, `agents.php`, `agent_data.php`, `orders.php`, `orders_data.json`

### 6. Manajemen Hotel & Kamar
- Tambah, edit, hapus hotel dan kamar (admin/agent).
- Upload gambar hotel dan kamar.
- Sistem rating hotel.
- Fitur pencarian dan filter hotel.
- **File utama:** `admin_properties.php`, `save_hotel.php`, `get_hotels.php`, `hotels_data.json`, `images/`, `properties.php`, `properties.css`

### 7. Manajemen Pesanan
- Tabel riwayat pesanan dengan status (pending, confirmed, cancelled).
- Edit dan hapus pesanan (admin).
- Laporan statistik pemesanan harian, bulanan, dan total.
- **File utama:** `orders.php`, `orders_data.json`, `save_order.php`, `booking.php`, `booking_properties.php`

### 8. Fitur Pembatalan & Refund
- Ajukan pembatalan pesanan dan proses refund sesuai kebijakan.
- **File utama:** (integrasi di `orders.php`, `payment.php`)

### 9. Layanan Pelanggan
- Chatbot asisten pemesanan hotel (Contact Admin).
- Kontak admin untuk bantuan dan pertanyaan.
- **File utama:** `contact_admin.php`, `chatbot.css`, `contact_admin.css`

### 10. Pengaturan Website (Admin)
- Ubah judul website, logo, warna tema, deskripsi, dan sosial media.
- Mode maintenance dan custom script.
- **File utama:** `website_setting.php`, `website_setting.css`

### 11. Fitur Lain
- Lihat fasilitas hotel, lokasi, galeri foto, dan layanan tambahan.
- Responsive design untuk desktop, tablet, dan mobile.
- Keamanan: validasi input, proteksi XSS & CSRF, validasi upload file.
- Notifikasi real-time (agent/admin).
- Shortcut keyboard untuk aksi cepat.

---

## Peran Pengguna

- **User:**
  - Mencari hotel, memesan kamar, mengelola keranjang, melakukan pembayaran, dan mengatur profil.
- **Agent:**
  - Mengelola hotel milik sendiri, melihat statistik, mengelola pesanan, dan laporan performa.
- **Admin:**
  - Mengelola seluruh data hotel, kamar, agent, pesanan, pengaturan website, dan laporan global.

---

## Alur Utama Penggunaan

1. **Pencarian Hotel** → 2. **Lihat Detail & Fasilitas** → 3. **Tambah ke Keranjang** → 4. **Checkout & Isi Data Pemesanan** → 5. **Pilih Metode Pembayaran** → 6. **Konfirmasi & Dapatkan Kode Pembayaran** → 7. **Riwayat & Manajemen Pesanan**

---

## Teknologi yang Digunakan
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Backend:** PHP 7.4+
- **Styling:** Custom CSS, Bootstrap 5
- **Icons:** Font Awesome
- **Font:** Google Fonts (Poppins)

---

## Struktur File Utama

```
PemesananHotel/
├── index.php, layanan.php, properties.php, booking.php, booking_properties.php
├── cart.php, payment.php, va_code.php
├── admin_dashboard.php, agent_dashboard.php, agents.php
├── orders.php, save_order.php, orders_data.json
├── Register.php, login.php, profile.php, account_security.php, settings.php
├── contact_admin.php, chatbot.css
├── website_setting.php
├── hotels_data.json, get_hotels.php, save_hotel.php
├── images/
└── ... (file CSS & JS pendukung)
```

---

## Responsivitas & Keamanan
- Desain responsif untuk desktop, tablet, dan mobile.
- Validasi input, proteksi XSS & CSRF, validasi upload file.

## Lisensi
Proyek ini menggunakan lisensi MIT. Lihat file LICENSE untuk detail lebih lanjut.

## Support
Untuk dukungan teknis atau pertanyaan, silakan hubungi tim pengembangan atau buat issue di repository.

---

**Versi:** 2.0.0+ (fitur lengkap)
**Terakhir Diperbarui:** Juli 2025
**Status:** Production Ready 