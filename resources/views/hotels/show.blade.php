@extends('layouts.app')

@section('title', $hotel->name)

@php
    $photos = array_values(array_filter(array_merge([$hotel->imageUrl()], $hotel->galleryUrls())));
    $facilityIcons = ['wi-fi' => 'fa-wifi', 'wifi' => 'fa-wifi', 'pool' => 'fa-person-swimming', 'spa' => 'fa-spa', 'fitness' => 'fa-dumbbell',
        'restaurant' => 'fa-utensils', 'dining' => 'fa-utensils', 'bar' => 'fa-martini-glass', 'meeting' => 'fa-people-roof', 'beach' => 'fa-umbrella-beach',
        'business' => 'fa-briefcase', 'butler' => 'fa-bell-concierge', 'family' => 'fa-children', 'lounge' => 'fa-couch'];
    $iconFor = function ($facility) use ($facilityIcons) {
        foreach ($facilityIcons as $needle => $icon) {
            if (str_contains(strtolower($facility), $needle)) return $icon;
        }
        return 'fa-circle-check';
    };
    $reviewCount = $hotel->reviews->count();
@endphp

@section('content')
    <section class="section-sm">
        <div class="container">
            <div class="breadcrumb muted small reveal" style="margin-bottom:1rem">
                <a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('services') }}">Hotel</a> / {{ $hotel->name }}
            </div>

            <div class="section-head reveal" style="margin-bottom:1.2rem">
                <div>
                    <h1 class="display" style="font-size:clamp(1.8rem,4vw,2.8rem);margin:0">{{ $hotel->name }}</h1>
                    <div class="chips" style="margin-top:.6rem">
                        <span class="chip"><i class="fas fa-star" style="color:var(--gold-2)"></i> {{ number_format($hotel->rating, 1) }} · {{ $reviewCount }} ulasan</span>
                        <span class="chip"><i class="fas fa-location-dot"></i> {{ $hotel->location }}</span>
                        @if ($hotel->phone)<span class="chip"><i class="fas fa-phone"></i> {{ $hotel->phone }}</span>@endif
                    </div>
                </div>
                <div style="display:flex;gap:.5rem">
                    <button type="button" class="btn btn-outline {{ $inWishlist ? 'active' : '' }}" data-wishlist-url="{{ route('wishlist.toggle', $hotel) }}" data-login-url="{{ route('login') }}" data-label>
                        <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart" style="color:var(--danger)"></i> <span>{{ $inWishlist ? 'Tersimpan' : 'Simpan' }}</span>
                    </button>
                    <button type="button" class="btn btn-outline" onclick="navigator.share ? navigator.share({title: document.title, url: location.href}) : navigator.clipboard.writeText(location.href).then(() => toast('Link disalin'))">
                        <i class="fas fa-share-nodes"></i> Bagikan
                    </button>
                </div>
            </div>

            <div class="gallery reveal">
                @foreach (array_slice($photos, 0, 5) as $photo)
                    <a href="{{ $photo }}" data-lightbox><img src="{{ $photo }}" alt="{{ $hotel->name }}" loading="lazy"></a>
                @endforeach
            </div>

            <div class="detail-layout" style="margin-top:2rem">
                <div style="display:grid;gap:1.5rem">
                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-circle-info text-gold"></i> Tentang hotel</div>
                        <div class="prose">{{ $hotel->description }}</div>
                    </div>

                    @if ($hotel->facilities)
                        <div class="card reveal">
                            <div class="card-title"><i class="fas fa-concierge-bell text-gold"></i> Fasilitas</div>
                            <div class="facility-grid">
                                @foreach ($hotel->facilities as $facility)
                                    <div class="facility"><i class="fas {{ $iconFor($facility) }}"></i> {{ $facility }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-bed text-gold"></i> Tipe kamar</div>
                        @foreach ($hotel->roomTypes as $room)
                            <div class="room-row">
                                <div>
                                    <strong>{{ $room->name }}</strong><br>
                                    <span class="muted small"><i class="fas fa-door-open"></i> {{ $room->total_rooms }} kamar · maks. 4 tamu</span>
                                </div>
                                <div style="text-align:right">
                                    <strong style="font-size:1.1rem">{{ rupiah($room->pricePerNight()) }}</strong><span class="muted small"> / malam</span><br>
                                    <a href="{{ route('bookings.create', ['hotel' => $hotel, 'room' => $room->id]) }}" class="btn btn-primary btn-sm" style="margin-top:.4rem">Pilih</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Ulasan --}}
                    <div class="card reveal" id="reviews">
                        <div class="card-title"><i class="fas fa-comments text-gold"></i> Ulasan tamu</div>
                        <div style="display:grid;grid-template-columns:auto 1fr;gap:2rem;align-items:center;margin-bottom:1rem" class="review-summary">
                            <div style="text-align:center">
                                <div class="rating-big">{{ number_format($hotel->rating, 1) }}</div>
                                @include('partials.stars', ['rating' => $hotel->rating])
                                <div class="muted small">{{ $reviewCount }} ulasan</div>
                            </div>
                            <div>
                                @foreach ($ratingBreakdown as $star => $count)
                                    <div style="display:flex;align-items:center;gap:.6rem;font-size:.85rem">
                                        <span style="width:28px">{{ $star }} ★</span>
                                        <div class="bar"><span style="width:{{ $reviewCount ? round($count / $reviewCount * 100) : 0 }}%"></span></div>
                                        <span class="muted" style="width:24px;text-align:right">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($canReview)
                            <form method="POST" action="{{ route('reviews.store', $hotel) }}" class="card" style="background:var(--bg);margin-bottom:1rem">
                                @csrf
                                <strong>{{ $myReview ? 'Perbarui ulasan Anda' : 'Tulis ulasan' }}</strong>
                                <div class="star-input" style="margin:.4rem 0">
                                    @for ($s = 5; $s >= 1; $s--)
                                        <input type="radio" id="star{{ $s }}" name="rating" value="{{ $s }}" @checked(old('rating', $myReview?->rating ?? 5) == $s)>
                                        <label for="star{{ $s }}" title="{{ $s }} bintang"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                                <div class="field">
                                    <textarea name="comment" maxlength="1000" placeholder="Ceritakan pengalaman menginap Anda...">{{ old('comment', $myReview?->comment) }}</textarea>
                                </div>
                                <div style="display:flex;gap:.5rem;margin-top:.8rem">
                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-paper-plane"></i> Kirim ulasan</button>
                                    @if ($myReview)
                                        <button class="btn btn-outline btn-sm" type="submit" form="deleteReview">Hapus</button>
                                    @endif
                                </div>
                            </form>
                            @if ($myReview)
                                <form id="deleteReview" method="POST" action="{{ route('reviews.destroy', $hotel) }}" onsubmit="return confirm('Hapus ulasan Anda?')">@csrf @method('DELETE')</form>
                            @endif
                        @elseif (auth()->check() && auth()->user()->role === 'user')
                            <p class="muted small"><i class="fas fa-circle-info"></i> Ulasan bisa ditulis setelah Anda membayar pesanan di hotel ini.</p>
                        @endif

                        @forelse ($hotel->reviews as $review)
                            <div class="review">
                                <div style="display:flex;justify-content:space-between;gap:1rem;align-items:center">
                                    <div class="agent-chip"><img src="{{ $review->user->avatarUrl() }}" alt=""><strong style="color:var(--text)">{{ $review->user->name }}</strong></div>
                                    <span class="muted small">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="margin:.4rem 0">@include('partials.stars', ['rating' => $review->rating])</div>
                                @if ($review->comment)<p style="margin:0" class="muted">{{ $review->comment }}</p>@endif
                            </div>
                        @empty
                            <p class="muted">Belum ada ulasan untuk hotel ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Kartu booking --}}
                <aside class="sticky">
                    <div class="card reveal" data-tilt="4" style="box-shadow:var(--shadow-lg)">
                        <span class="muted small">Mulai dari</span>
                        <div style="font-size:1.8rem;font-weight:700">{{ $hotel->formattedPrice() }} <span class="muted small" style="font-weight:400">/ malam</span></div>
                        <p class="muted small" style="margin:.2rem 0 1rem">Sudah termasuk konfirmasi instan. Pajak 10% + layanan 1% dihitung saat checkout.</p>
                        <a href="{{ route('bookings.create', $hotel) }}" class="btn btn-primary btn-block btn-lg"><i class="fas fa-calendar-check"></i> Pesan sekarang</a>
                        <button type="button" class="btn btn-outline btn-block" style="margin-top:.6rem" data-cart-url="{{ route('cart.add', $hotel) }}" data-login-url="{{ route('login') }}">
                            <i class="fas fa-cart-plus"></i> Tambah ke keranjang
                        </button>
                        @if ($hotel->agent)
                            <div class="divider">Dikelola oleh</div>
                            <a href="{{ route('agents') }}#agent-{{ $hotel->agent->id }}" class="agent-chip" style="font-size:.95rem">
                                <img src="{{ $hotel->agent->avatarUrl() }}" alt="" style="width:44px;height:44px">
                                <div><strong style="color:var(--text)">{{ $hotel->agent->name }}</strong><br><span class="small">{{ $hotel->agent->phone }}</span></div>
                            </a>
                        @endif
                    </div>
                </aside>
            </div>

            @if ($similar->isNotEmpty())
                <div class="section-head reveal" style="margin-top:4rem"><div><span class="kicker">Lainnya</span><h2>Hotel serupa</h2></div></div>
                <div class="grid grid-3">
                    @foreach ($similar as $hotel)
                        @include('partials.hotel-card', ['wishlistIds' => []])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true">
        <button type="button" class="btn btn-glass btn-icon" data-lightbox-close aria-label="Tutup"><i class="fas fa-xmark"></i></button>
        <img src="" alt="Foto hotel">
    </div>
@endsection
