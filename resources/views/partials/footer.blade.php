<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="brand" style="color:#fff">
                    <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="Logo">
                    <span>{{ $site['site_title'] }}</span>
                </a>
                <p style="margin-top:1rem;max-width:340px">Layanan properti modern untuk penyewaan hotel — tempat kenyamanan, kemudahan, dan gaya hidup bertemu.</p>
                <div class="socials">
                    @if ($site['instagram'])<a href="{{ $site['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>@endif
                    @if ($site['facebook'])<a href="{{ $site['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                    @if ($site['whatsapp'])<a href="https://wa.me/{{ preg_replace('/\D/', '', $site['whatsapp']) }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>@endif
                    <a href="mailto:{{ $site['email'] }}" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div>
                <h4>Jelajahi</h4>
                <a href="{{ route('services') }}">Semua Hotel</a>
                <a href="{{ route('properties') }}">Properties</a>
                <a href="{{ route('agents') }}">Agent Kami</a>
            </div>
            <div>
                <h4>Akun</h4>
                <a href="{{ route('bookings.index') }}">Pesanan Saya</a>
                <a href="{{ route('wishlist.index') }}">Wishlist</a>
                <a href="{{ route('language') }}">Bahasa</a>
            </div>
            <div>
                <h4>Kontak</h4>
                <a href="{{ route('contact') }}"><i class="fas fa-robot"></i> Asisten Virtual</a>
                <a href="mailto:{{ $site['email'] }}"><i class="fas fa-envelope"></i> {{ $site['email'] }}</a>
                <a href="tel:{{ $site['phone'] }}"><i class="fas fa-phone"></i> {{ $site['phone'] }}</a>
                <span style="font-size:.9rem"><i class="fas fa-location-dot"></i> {{ $site['address'] }}</span>
            </div>
        </div>
        <div class="footer-bottom">
            <span>{{ $site['footer_text'] }}</span>
            <span>Dibuat dengan <i class="fas fa-heart" style="color:#f472b6"></i> di Indonesia</span>
        </div>
    </div>
</footer>
