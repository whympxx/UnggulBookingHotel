<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.head')
    <title>Pilih Akun - {{ $site['site_title'] }}</title>
</head>
<body>
    <section class="hero" style="margin-top:0;padding-top:0;min-height:100vh">
        <div class="hero-canvas" data-hero3d data-variant="auth" aria-hidden="true" style="opacity:.55"></div>
        <div class="container" style="position:relative;z-index:2;padding:3rem 0">
            <div style="text-align:center;margin-bottom:2.5rem">
                <a href="{{ route('home') }}" class="brand" style="color:#fff;justify-content:center">
                    <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="Logo"><span>{{ $site['site_title'] }}</span>
                </a>
                <h1 class="display" style="font-size:clamp(2rem,4vw,3rem);margin:1.5rem 0 .5rem">Masuk sebagai siapa?</h1>
                <p style="color:#cbd5f5">Pilih jenis akun Anda untuk melanjutkan.</p>
            </div>
            <div class="grid grid-3" style="max-width:980px;margin:auto">
                @foreach ([
                    ['user', 'fa-user', 'Customer', 'Cari, pesan, dan bayar hotel favorit Anda.', 'login', 'register'],
                    ['agent', 'fa-user-tie', 'Agent', 'Kelola hotel, pesanan, dan laporan pendapatan.', 'agent.login', 'agent.register'],
                    ['admin', 'fa-user-shield', 'Admin', 'Kelola seluruh sistem, agent, dan pengaturan.', 'admin.login', filled(config('app.admin_registration_code')) ? 'admin.register' : null],
                ] as $i => [$role, $icon, $title, $text, $login, $register])
                    <div class="role-card reveal reveal-delay-{{ $i }}" data-tilt="14">
                        <div class="ico"><i class="fas {{ $icon }}"></i></div>
                        <h3>{{ $title }}</h3>
                        <p style="color:#cbd5f5;font-size:.92rem">{{ $text }}</p>
                        <div class="btns">
                            <a href="{{ route($login) }}" class="btn btn-gold btn-sm">Login</a>
                            @if ($register)<a href="{{ route($register) }}" class="btn btn-glass btn-sm">Registrasi</a>@endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="text-align:center;margin-top:2.5rem">
                <a href="{{ route('home') }}" class="btn btn-glass"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="{{ asset('js/hero3d.js') }}?v=2"></script>
</body>
</html>
