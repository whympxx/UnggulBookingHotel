# Changelog

Semua perubahan penting pada proyek akan didokumentasikan dalam file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.1.0] - 2026-11-04

### Desain baru
- Design system baru (`public/css/modern.css`): navbar kaca, gradien navy-ungu dengan aksen emas, tipografi Playfair Display + Poppins, mode terang/gelap (tersimpan di browser).
- Seluruh halaman customer, agent, dan admin memakai tampilan baru; CSS lama per halaman dihapus.
- Dashboard admin & agent dengan sidebar baru, kartu statistik, dan grafik yang mengikuti tema.

### Animasi 3D
- Scene 3D interaktif (Three.js) di beranda, halaman pilih akun, dan login/registrasi: gedung hotel low-poly di atas pulau melayang, cincin emas, orb, partikel bintang; mengikuti gerakan mouse.
- Efek 3D tilt pada kartu hotel, destinasi, statistik, dan agent; animasi reveal 3D saat scroll; kubus 3D CSS; animasi QRIS, modal, dan toast.
- Menghormati `prefers-reduced-motion` dan punya fallback jika WebGL tidak tersedia.

### Fitur baru
- Halaman detail hotel (galeri + lightbox, fasilitas, tipe kamar, hotel serupa, tombol bagikan).
- Ulasan & rating dari tamu yang sudah membayar; rating hotel dihitung dari rata-rata ulasan.
- Wishlist hotel favorit.
- Halaman Jelajahi dengan filter lokasi, rentang harga, rating minimum, dan urutan.
- Kode promo (persen/nominal, minimal transaksi, kuota, kadaluarsa) + halaman kelola promo di admin.
- Invoice / e-ticket yang bisa dicetak atau disimpan sebagai PDF.
- Statistik pendapatan & grafik 6 bulan terakhir di dashboard admin.
- Badge jumlah keranjang & wishlist di navbar, notifikasi toast.

## [3.0.0] - 2026-11-04

### Migrasi ke Laravel 12
- Seluruh aplikasi PHP native diganti menjadi Laravel (routes, controller, Eloquent, Blade, middleware role).
- Data hotel, agent, dan pesanan pindah dari array hardcode / file JSON / $_SESSION ke database (migrasi + seeder).
- CSS dan gambar dipindah ke `public/css` dan `public/images`; arsitektur FSD lama (`src/`) yang tidak terpakai dihapus.

### Diperbaiki
- Login & registrasi customer, registrasi agent/admin sebelumnya tidak memproses form; login agent/admin memakai database `hotel_db` yang tidak pernah dibuat.
- Halaman admin & agent bisa dibuka tanpa login; registrasi admin terbuka untuk publik.
- Data kartu hotel di Layanan tidak cocok dengan yang dipesan (mis. kartu Fairfield memesan Novotel, kartu Kempinski memesan "Holiday Inn", harga Rp 8.000.000).
- `booking_properties.php` mengirim ke `process_booking.php` yang tidak ada; `update_hotel.php`/`delete_hotel.php` juga tidak ada.
- Harga, nama hotel, dan total pembayaran diambil dari URL sehingga bisa diubah user; pajak tertulis 10% + 1% tetapi dipakai angka tetap Rp 522.500.
- "Checkout Semua" tidak menyimpan pesanan; keranjang tercampur antara localStorage dan session.
- `admin_dashboard_data.php` meng-include halaman HTML sehingga JSON grafik realtime selalu rusak; total kamar/agent di-hardcode.
- Statistik dashboard agent palsu; `agent_data.php` memakai agent default `AGENT1` dan field yang tidak ada.
- ID order dihitung `count()+1` (bisa dobel); hapus order lewat link GET.
- Halaman bahasa mencetak HTML sebelum `session_start()` sehingga redirect gagal.
- Website Setting mencetak custom JS/analytics mentah (XSS) dan pengaturannya tidak dipakai di halaman lain.
- Celah XSS di render kartu hotel & chatbot (innerHTML).
- `images/default-hotel.jpg` bukan file gambar; QRIS menampilkan logo, bukan barcode.
- Profil, Akun & Keamanan, Ganti Password hanya tampilan statis (tidak menyimpan, logout hanya reload).

### Ditambahkan
- Cek ketersediaan kamar per tanggal, batas waktu pembayaran (VA 24 jam, QRIS 15 menit), halaman Pesanan Saya + batal pesanan.
- Reset password via email, CSRF di semua form, rate limit login.
- Feature test (46 test).

## [2.0.0] - 2024-01-15

### 🎉 Major Release - Complete Dashboard Redesign

#### ✨ Added
- **Dashboard Overview**: Halaman dashboard utama dengan statistik real-time
- **Statistics Cards**: Kartu statistik dengan trend indicators
- **Recent Bookings**: Daftar pemesanan terbaru dengan status
- **Quick Actions**: Shortcut untuk fungsi-fungsi utama
- **Modern UI Design**: Glassmorphism design dengan gradient background
- **Responsive Layout**: Fully responsive untuk semua device
- **Hotel Management**: Sistem manajemen hotel yang lengkap
- **Image Upload**: Upload gambar dengan preview real-time
- **Search & Filter**: Pencarian dan filter hotel berdasarkan rating
- **Booking Management**: Sistem manajemen pemesanan
- **Reports Section**: Generate laporan performa
- **Settings Panel**: Pengaturan akun dan notifikasi
- **Notification System**: Sistem notifikasi real-time
- **Keyboard Shortcuts**: Shortcut keyboard untuk produktivitas
- **Tooltips**: Tooltip informatif untuk UX yang lebih baik
- **Loading Animations**: Animasi loading yang smooth
- **Accessibility Features**: Dukungan aksesibilitas yang komprehensif

#### 🔧 Enhanced
- **Form Validation**: Validasi form yang lebih robust
- **AJAX Integration**: Integrasi AJAX untuk interaksi yang smooth
- **Error Handling**: Penanganan error yang lebih baik
- **Performance**: Optimasi performa dengan lazy loading
- **Security**: Peningkatan keamanan dengan validasi input
- **Mobile Experience**: Pengalaman mobile yang lebih baik

#### 🎨 Design Improvements
- **Color Scheme**: Skema warna yang modern dan konsisten
- **Typography**: Tipografi yang lebih readable
- **Spacing**: Spacing yang lebih harmonis
- **Animations**: Animasi yang smooth dan tidak mengganggu
- **Hover Effects**: Efek hover yang interaktif
- **Card Design**: Desain card yang modern

#### 📱 Responsive Design
- **Desktop Layout**: Layout optimal untuk desktop
- **Tablet Layout**: Layout yang menyesuaikan untuk tablet
- **Mobile Layout**: Layout stack untuk mobile
- **Touch Friendly**: Interface yang friendly untuk touch

#### 🔒 Security Enhancements
- **Input Sanitization**: Sanitasi input untuk mencegah XSS
- **File Upload Security**: Validasi file upload yang aman
- **Session Management**: Manajemen session yang lebih baik
- **CSRF Protection**: Proteksi CSRF

#### ♿ Accessibility
- **ARIA Labels**: Label ARIA untuk screen readers
- **Keyboard Navigation**: Navigasi keyboard yang lengkap
- **Focus Management**: Manajemen focus yang baik
- **High Contrast Support**: Dukungan mode kontras tinggi
- **Reduced Motion**: Dukungan preferensi reduced motion

#### 🚀 Performance
- **Optimized CSS**: CSS yang dioptimalkan
- **Efficient JavaScript**: JavaScript yang efisien
- **Lazy Loading**: Lazy loading untuk gambar
- **Minimal Dependencies**: Dependencies yang minimal

### 🐛 Fixed
- Form submission issues
- Mobile navigation problems
- Image upload errors
- Search functionality bugs
- Responsive layout issues

### 📚 Documentation
- **README.md**: Dokumentasi lengkap dengan panduan penggunaan
- **API Documentation**: Dokumentasi API endpoints
- **Troubleshooting Guide**: Panduan troubleshooting
- **Customization Guide**: Panduan kustomisasi

### 🔧 Technical Details
- **PHP 7.4+**: Dukungan PHP versi terbaru
- **Modern JavaScript**: ES6+ features
- **CSS Grid & Flexbox**: Layout modern
- **JSON Database**: Database berbasis JSON
- **RESTful API**: API yang RESTful

---

## [1.0.0] - 2024-01-01

### 🎉 Initial Release
- Basic agent dashboard functionality
- Simple hotel management
- Basic booking system
- Standard UI design

---

## Version History

- **v2.0.0**: Complete redesign with modern features
- **v1.0.0**: Initial release with basic functionality

---

## Migration Guide

### From v1.0.0 to v2.0.0

#### Breaking Changes
- Complete UI redesign
- New file structure
- Updated API endpoints
- Changed CSS classes

#### Migration Steps
1. Backup existing data
2. Replace old files with new versions
3. Update database structure (if applicable)
4. Test all functionality
5. Update any custom integrations

#### New Features to Explore
- Dashboard overview with statistics
- Modern hotel management interface
- Enhanced booking system
- Advanced search and filter
- Real-time notifications
- Keyboard shortcuts
- Accessibility features

---

## Support

Untuk dukungan migrasi atau pertanyaan teknis, silakan hubungi tim pengembangan.

---

**Note**: Versi 2.0.0 adalah major release dengan perubahan signifikan pada UI/UX dan fungsionalitas. Pastikan untuk melakukan testing menyeluruh sebelum deployment ke production. 