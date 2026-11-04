@php
    $user = auth()->user();
    $links = [
        ['home', 'Beranda'],
        ['services', 'Jelajahi'],
        ['properties', 'Properties'],
        ['agents', 'Agent'],
        ['contact', 'Bantuan'],
    ];
@endphp
<header class="navbar {{ $transparent ?? false ? 'is-transparent' : '' }}">
    <div class="container nav-inner">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="Logo">
            <span>{{ $site['site_title'] }}</span>
        </a>

        <nav class="nav-links" id="navLinks">
            @foreach ($links as [$route, $label])
                <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="nav-actions">
            <button type="button" class="icon-btn" onclick="toggleTheme()" aria-label="Ganti tema terang/gelap" title="Mode gelap">
                <i class="fas fa-moon" data-theme-icon></i>
            </button>

            @if (! $user || $user->role === 'user')
                <a href="{{ route('wishlist.index') }}" class="icon-btn hide-mobile" aria-label="Wishlist" title="Wishlist">
                    <i class="far fa-heart"></i>
                    <span class="count-badge {{ ($navCounts['wishlist'] ?? 0) ? '' : 'hidden' }}" data-badge="wishlist">{{ $navCounts['wishlist'] ?? 0 }}</span>
                </a>
                <a href="{{ route('cart.index') }}" class="icon-btn" aria-label="Keranjang" title="Keranjang">
                    <i class="fas fa-bag-shopping"></i>
                    <span class="count-badge {{ ($navCounts['cart'] ?? 0) ? '' : 'hidden' }}" data-badge="cart">{{ $navCounts['cart'] ?? 0 }}</span>
                </a>
            @endif

            @guest
                <a href="{{ route('auth.select') }}" class="btn btn-primary btn-sm">Masuk</a>
            @else
                <div class="dropdown">
                    <button type="button" class="link-button" data-dropdown aria-label="Menu akun">
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="avatar">
                    </button>
                    <div class="dropdown-menu">
                        <div style="padding:.5rem .75rem">
                            <strong>{{ $user->name }}</strong><br>
                            <span class="muted small">{{ $user->email }}</span>
                        </div>
                        <hr>
                        @if ($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard Admin</a>
                        @elseif ($user->isAgent())
                            <a href="{{ route('agent.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard Agent</a>
                        @else
                            <a href="{{ route('bookings.index') }}"><i class="fas fa-receipt"></i> Pesanan Saya</a>
                            <a href="{{ route('wishlist.index') }}"><i class="far fa-heart"></i> Wishlist</a>
                        @endif
                        <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profil</a>
                        <a href="{{ route('settings') }}"><i class="fas fa-gear"></i> Pengaturan</a>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fas fa-arrow-right-from-bracket"></i> Logout</button>
                        </form>
                    </div>
                </div>
            @endguest

            <button type="button" class="icon-btn nav-toggle" data-nav-toggle="#navLinks" aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>
