@php
    $wished = in_array($hotel->id, $wishlistIds ?? [], true);
@endphp
<article class="hotel-card reveal" data-tilt="8">
    <div class="media">
        <a href="{{ route('hotels.show', $hotel) }}" aria-label="{{ $hotel->name }}">
            <img src="{{ $hotel->imageUrl() }}" alt="{{ $hotel->name }}" loading="lazy">
        </a>
        <span class="rating-pill"><i class="fas fa-star"></i> {{ number_format($hotel->rating, 1) }}
            @if ($hotel->reviews_count) <span class="muted" style="font-weight:500">({{ $hotel->reviews_count }})</span> @endif
        </span>
        <button type="button" class="wish-btn {{ $wished ? 'active' : '' }}" data-wishlist-url="{{ route('wishlist.toggle', $hotel) }}" data-login-url="{{ route('login') }}" aria-label="Simpan ke wishlist">
            <i class="{{ $wished ? 'fas' : 'far' }} fa-heart"></i>
        </button>
        <span class="price-tag">{{ $hotel->formattedPrice() }} <small>/ malam</small></span>
    </div>
    <div class="body">
        <h3><a href="{{ route('hotels.show', $hotel) }}">{{ $hotel->name }}</a></h3>
        <div class="meta"><i class="fas fa-location-dot"></i> {{ $hotel->location }}</div>
        @if ($hotel->agent)
            <div class="agent-chip"><img src="{{ $hotel->agent->avatarUrl() }}" alt=""> {{ $hotel->agent->name }}</div>
        @endif
        <div class="card-actions">
            <a href="{{ route('bookings.create', $hotel) }}" class="btn btn-primary btn-sm">Pesan Kamar</a>
            <button type="button" class="btn btn-ghost btn-sm" style="flex:0 0 auto" data-cart-url="{{ route('cart.add', $hotel) }}" data-login-url="{{ route('login') }}" aria-label="Tambah ke keranjang" title="Tambah ke keranjang">
                <i class="fas fa-cart-plus"></i>
            </button>
        </div>
    </div>
</article>
