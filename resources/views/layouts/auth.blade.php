<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.head')
    <title>@yield('title') - {{ $site['site_title'] }}</title>
</head>
<body>
    <div class="auth">
        <div class="auth-visual">
            <div class="hero-canvas" data-hero3d data-variant="auth" aria-hidden="true"></div>
            <a href="{{ route('home') }}" class="brand" style="color:#fff">
                <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="Logo">
                <span>{{ $site['site_title'] }}</span>
            </a>
            <div class="auth-quote">
                <h2>@yield('visual-title', 'Liburan impian dimulai dari sini.')</h2>
                <p style="color:#cbd5f5;max-width:420px">@yield('visual-text', 'Pesan hotel favorit Anda dalam hitungan detik dengan harga transparan dan pembayaran aman.')</p>
            </div>
            <div class="small" style="color:#a5b4fc"><i class="fas fa-computer-mouse"></i> Gerakkan mouse untuk memutar scene 3D</div>
        </div>
        <div class="auth-panel">
            <div class="auth-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
                    <a href="{{ route('home') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Beranda</a>
                    <button type="button" class="icon-btn" onclick="toggleTheme()" aria-label="Ganti tema"><i class="fas fa-moon" data-theme-icon></i></button>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="{{ asset('js/hero3d.js') }}?v=2"></script>
</body>
</html>
