@extends('layouts.app')

@section('title', 'Beranda')
@section('transparent-nav', '1')

@section('hero')
    <section class="hero">
        <div class="hero-fallback" style="background-image:url('{{ asset('images/bg-hotel.jpg') }}')"></div>
        <div class="hero-canvas" data-hero3d data-variant="hero" aria-hidden="true"></div>
        <div class="container">
            <div class="hero-content">
                <span class="eyebrow"><i class="fas fa-wand-magic-sparkles text-gold"></i> {{ $stats['hotels'] }} hotel pilihan di {{ $stats['cities'] }} kota</span>
                <h1>Temukan <span class="text-gradient">pengalaman menginap</span> terbaik Anda</h1>
                <p class="lead">{{ $site['welcome_message'] }}</p>

                <form class="search-box" action="{{ route('services') }}" method="GET" role="search">
                    <label class="field-icon">
                        <span class="sr-only">Cari hotel</span>
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Cari nama hotel atau kota..." id="searchInput" autocomplete="off">
                    </label>
                    <label class="field-icon">
                        <span class="sr-only">Lokasi</span>
                        <i class="fas fa-location-dot"></i>
                        <select name="location" id="locationSelect">
                            <option value="all">Semua Lokasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn btn-gold btn-lg" type="submit"><i class="fas fa-search"></i> Cari</button>
                </form>

                <div class="hero-stats">
                    <div><strong data-count="{{ $stats['hotels'] }}">{{ $stats['hotels'] }}</strong><span>Hotel</span></div>
                    <div><strong data-count="{{ $stats['cities'] }}">{{ $stats['cities'] }}</strong><span>Kota</span></div>
                    <div><strong data-count="{{ $stats['rating'] }}">{{ $stats['rating'] }}</strong><span>Rating rata-rata</span></div>
                    <div><strong data-count="{{ $stats['guests'] }}" data-suffix="+">{{ $stats['guests'] }}</strong><span>Tamu terlayani</span></div>
                </div>
            </div>
        </div>
        <div class="hero-scroll"><i class="fas fa-computer-mouse"></i><br>Gerakkan mouse &amp; scroll</div>
    </section>
@endsection

@section('content')
    {{-- Rekomendasi (live search) --}}
    <section class="section">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <span class="kicker">Rekomendasi</span>
                    <h2>Hotel dengan rating tertinggi</h2>
                    <p>Hasil berubah otomatis saat Anda mengetik di kolom pencarian.</p>
                </div>
                <a href="{{ route('services') }}" class="btn btn-outline">Lihat semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="grid grid-4" id="hotelCardsRow">
                @foreach ($hotels as $hotel)
                    @include('partials.hotel-card')
                @endforeach
            </div>
        </div>
    </section>

    {{-- Destinasi --}}
    <section class="section" style="background:var(--bg-2)">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <span class="kicker">Destinasi</span>
                    <h2>Destinasi favorit</h2>
                </div>
            </div>
            <div class="grid grid-3">
                @foreach ($destinations as $i => $dest)
                    <a href="{{ route('services', ['location' => $dest['city']]) }}" class="dest-card reveal reveal-delay-{{ $i % 3 }}" data-tilt="12">
                        <img src="{{ $dest['image'] }}" alt="{{ $dest['city'] }}" loading="lazy">
                        <div>
                            <h3>{{ $dest['city'] }}</h3>
                            <span>{{ $dest['count'] }} hotel tersedia</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Kenapa kami --}}
    <section class="section">
        <div class="container">
            <div class="section-head reveal" style="justify-content:center;text-align:center">
                <div>
                    <span class="kicker">Kenapa kami</span>
                    <h2>Booking mudah, aman, dan cepat</h2>
                </div>
            </div>
            <div class="grid grid-4">
                @foreach ([
                    ['fa-shield-halved', 'Pembayaran Aman', 'Harga dihitung oleh sistem, tidak bisa dimanipulasi. Bayar via BCA VA, QRIS, atau di tempat.'],
                    ['fa-bolt', 'Konfirmasi Instan', 'Ketersediaan kamar dicek real-time sehingga tidak ada double booking.'],
                    ['fa-tags', 'Promo Menarik', 'Gunakan kode promo seperti WELCOME10 untuk hemat di setiap transaksi.'],
                    ['fa-headset', 'Bantuan 24/7', 'Asisten virtual dan agent kami siap membantu kapan pun Anda butuh.'],
                ] as $i => [$icon, $title, $text])
                    <div class="feature reveal reveal-delay-{{ $i }}" data-tilt="10">
                        <div class="ico"><i class="fas {{ $icon }}"></i></div>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Populer / premium --}}
    <section class="section" style="background:var(--bg-2)">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <span class="kicker">Premium</span>
                    <h2>Koleksi hotel mewah</h2>
                </div>
            </div>
            <div class="grid grid-3">
                @foreach ($popular as $hotel)
                    @include('partials.hotel-card')
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    @if ($testimonials->isNotEmpty())
        <section class="section">
            <div class="container">
                <div class="section-head reveal">
                    <div>
                        <span class="kicker">Testimoni</span>
                        <h2>Kata tamu kami</h2>
                    </div>
                </div>
                <div class="grid grid-3">
                    @foreach ($testimonials as $i => $review)
                        <div class="quote-card reveal reveal-delay-{{ $i }}" data-tilt="6">
                            @include('partials.stars', ['rating' => $review->rating])
                            <p style="margin:.8rem 0 1.2rem">“{{ $review->comment }}”</p>
                            <div class="agent-chip">
                                <img src="{{ $review->user->avatarUrl() }}" alt="">
                                <div><strong style="color:var(--text)">{{ $review->user->name }}</strong><br>
                                    <a href="{{ route('hotels.show', $review->hotel) }}" class="small">{{ $review->hotel->name }}</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="section-sm">
        <div class="container">
            <div class="cta reveal">
                <div style="max-width:560px;position:relative;z-index:2">
                    <h2>Punya hotel? Jadi agent kami.</h2>
                    <p style="color:#e0e7ff">Daftarkan hotel Anda, kelola pemesanan, dan pantau pendapatan dari dashboard agent.</p>
                    <a href="{{ route('agent.register') }}" class="btn btn-gold btn-lg">Daftar sebagai Agent</a>
                </div>
                <div class="cube-wrap" style="perspective:600px" aria-hidden="true">
                    <div class="cube">
                        <div class="f1"><i class="fas fa-hotel"></i></div><div class="f2"><i class="fas fa-key"></i></div>
                        <div class="f3"><i class="fas fa-bed"></i></div><div class="f4"><i class="fas fa-star"></i></div>
                        <div class="f5"><i class="fas fa-umbrella-beach"></i></div><div class="f6"><i class="fas fa-plane"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('js/hero3d.js') }}?v=2"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Live search: hasil rekomendasi diperbarui saat mengetik
    const grid = document.getElementById('hotelCardsRow');
    const input = document.getElementById('searchInput');
    const select = document.getElementById('locationSelect');
    const loginUrl = @json(route('login'));
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const fmt = n => 'Rp. ' + Number(n).toLocaleString('id-ID');
    let timer;

    function render(hotels) {
        if (!hotels.length) {
            grid.innerHTML = '<div class="empty" style="grid-column:1/-1"><i class="fas fa-hotel"></i>Hotel tidak ditemukan. Coba kata kunci lain.</div>';
            return;
        }
        grid.innerHTML = hotels.slice(0, 8).map(h => `
            <article class="hotel-card reveal in" data-tilt="8">
                <div class="media">
                    <a href="${esc(h.url)}"><img src="${esc(h.image)}" alt="${esc(h.name)}" loading="lazy"></a>
                    <span class="rating-pill"><i class="fas fa-star"></i> ${Number(h.rating).toFixed(1)}</span>
                    <button type="button" class="wish-btn" data-wishlist-url="${esc(h.wishlist_url)}" data-login-url="${esc(loginUrl)}" aria-label="Simpan ke wishlist"><i class="far fa-heart"></i></button>
                    <span class="price-tag">${fmt(h.price)} <small>/ malam</small></span>
                </div>
                <div class="body">
                    <h3><a href="${esc(h.url)}">${esc(h.name)}</a></h3>
                    <div class="meta"><i class="fas fa-location-dot"></i> ${esc(h.location)}</div>
                    ${h.agent ? `<div class="agent-chip"><img src="${esc(h.agent_avatar)}" alt=""> ${esc(h.agent)}</div>` : ''}
                    <div class="card-actions">
                        <a href="${esc(h.book_url)}" class="btn btn-primary btn-sm">Pesan Kamar</a>
                        <button type="button" class="btn btn-ghost btn-sm" style="flex:0 0 auto" data-cart-url="${esc(h.cart_url)}" data-login-url="${esc(loginUrl)}" aria-label="Tambah ke keranjang"><i class="fas fa-cart-plus"></i></button>
                    </div>
                </div>
            </article>`).join('');
        window.initTilt(grid);
    }

    function search() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const params = new URLSearchParams({ search: input.value, location: select.value });
            fetch(@json(route('hotels.search')) + '?' + params, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json()).then(render).catch(() => {});
        }, 280);
    }
    input.addEventListener('input', search);
    select.addEventListener('change', search);
});
</script>
@endpush
