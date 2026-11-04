<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.head')
    <title>@yield('title') - {{ auth()->user()->isAdmin() ? 'Admin' : 'Agent' }} {{ $site['site_title'] }}</title>
    @stack('styles')
</head>
<body>
    @php
        $user = auth()->user();
        $menu = $user->isAdmin()
            ? [
                ['Utama', null, null],
                ['admin.dashboard', 'fa-gauge-high', 'Dashboard'],
                ['admin.orders.index', 'fa-receipt', 'Orders'],
                ['Properti', null, null],
                ['admin.hotels.index', 'fa-hotel', 'Hotel & Lokasi'],
                ['admin.rooms.index', 'fa-bed', 'Tipe Kamar'],
                ['Pengguna & Promo', null, null],
                ['admin.agents.index', 'fa-user-tie', 'Agent'],
                ['admin.promos.index', 'fa-ticket', 'Kode Promo'],
                ['Sistem', null, null],
                ['admin.settings.edit', 'fa-sliders', 'Website Setting'],
            ]
            : [
                ['Agent', null, null],
                ['agent.dashboard', 'fa-gauge-high', 'Dashboard', '#dashboard'],
                ['agent.dashboard', 'fa-plus', 'Tambah Hotel', '#add-hotel'],
                ['agent.dashboard', 'fa-building', 'Kelola Hotel', '#manage-hotels'],
                ['agent.dashboard', 'fa-calendar-check', 'Pemesanan', '#bookings'],
                ['agent.dashboard', 'fa-chart-line', 'Laporan', '#reports'],
            ];
    @endphp
    <div class="dash">
        <aside class="dash-side" id="dashSide">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="Logo"><span>{{ $site['site_title'] }}</span>
            </a>
            <nav class="dash-nav">
                @foreach ($menu as $item)
                    @if ($item[1] === null)
                        <span class="label">{{ $item[0] }}</span>
                    @else
                        @php $hash = $item[3] ?? null; @endphp
                        <a href="{{ route($item[0]).($hash ?? '') }}"
                           @if ($hash) data-section="{{ ltrim($hash, '#') }}" @endif
                           class="{{ ! $hash && request()->routeIs($item[0]) ? 'active' : '' }}">
                            <i class="fas {{ $item[1] }}"></i> {{ $item[2] }}
                        </a>
                    @endif
                @endforeach
                <span class="label">Akun</span>
                <a href="{{ route('settings') }}"><i class="fas fa-gear"></i> Pengaturan Akun</a>
                <a href="{{ route('home') }}"><i class="fas fa-globe"></i> Lihat Website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-arrow-right-from-bracket"></i> Logout</button>
                </form>
            </nav>
        </aside>

        <div class="dash-main">
            <header class="dash-top">
                <button type="button" class="icon-btn dash-burger" data-nav-toggle="#dashSide" aria-label="Menu"><i class="fas fa-bars"></i></button>
                <h1>@yield('title')</h1>
                <div style="margin-left:auto;display:flex;align-items:center;gap:.6rem">
                    <button type="button" class="icon-btn" onclick="toggleTheme()" aria-label="Ganti tema"><i class="fas fa-moon" data-theme-icon></i></button>
                    <div style="text-align:right;line-height:1.2" class="hide-mobile">
                        <strong style="font-size:.9rem">{{ $user->name }}</strong><br>
                        <span class="muted small">{{ $user->isAdmin() ? 'Administrator' : ($user->agency ?: 'Agent') }}</span>
                    </div>
                    <img src="{{ $user->avatarUrl() }}" alt="Foto profil" id="admin-profile-img" class="avatar" style="cursor:{{ $user->isAdmin() ? 'pointer' : 'default' }}" title="{{ $user->isAdmin() ? 'Ubah foto profil' : '' }}">
                </div>
            </header>
            <div class="dash-content">
                @include('partials.flash')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        // Warna Chart.js mengikuti tema
        function chartTheme() {
            const dark = document.documentElement.dataset.theme === 'dark';
            Chart.defaults.color = dark ? '#a5b4cf' : '#475569';
            Chart.defaults.borderColor = dark ? 'rgba(148,163,184,.14)' : 'rgba(15,23,42,.08)';
            Chart.defaults.font.family = 'Poppins, sans-serif';
        }
        chartTheme();
        document.addEventListener('themechange', () => { chartTheme(); Object.values(Chart.instances).forEach(c => c.update()); });
    </script>
    @stack('scripts')
</body>
</html>
