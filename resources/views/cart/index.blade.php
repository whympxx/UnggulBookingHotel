@extends('layouts.app')

@section('title', 'Keranjang Saya')
@section('page-title', 'Keranjang Saya')
@section('page-subtitle', 'Pesan beberapa hotel sekaligus dengan satu kali pembayaran.')

@section('content')
    <section class="section-sm">
        <div class="container">
            @if ($hotels->isEmpty())
                <div class="empty card reveal">
                    <i class="fas fa-bag-shopping"></i>
                    <h3>Keranjang Anda Kosong</h3>
                    <p>Silakan pilih hotel yang ingin Anda pesan.</p>
                    <a href="{{ route('services') }}" class="btn btn-primary"><i class="fas fa-magnifying-glass"></i> Jelajahi hotel</a>
                </div>
            @else
                <div class="detail-layout">
                    <div style="display:grid;gap:1rem">
                        @foreach ($hotels as $hotel)
                            <div class="card reveal" data-tilt="3" style="display:flex;gap:1.2rem;align-items:center;flex-wrap:wrap;padding:1rem">
                                <img src="{{ $hotel->imageUrl() }}" alt="{{ $hotel->name }}" style="width:160px;height:110px;object-fit:cover;border-radius:14px">
                                <div style="flex:1;min-width:200px">
                                    <h3 style="margin:0"><a href="{{ route('hotels.show', $hotel) }}" style="color:var(--text)">{{ $hotel->name }}</a></h3>
                                    <div class="meta"><i class="fas fa-location-dot"></i> {{ $hotel->location }}</div>
                                    <div class="meta"><i class="fas fa-star" style="color:var(--gold-2)"></i> {{ number_format($hotel->rating, 1) }}</div>
                                    <strong>{{ $hotel->formattedPrice() }}</strong> <span class="muted small">/ malam</span>
                                </div>
                                <div class="actions">
                                    <a href="{{ route('bookings.create', $hotel) }}" class="btn btn-primary btn-sm"><i class="fas fa-calendar-check"></i> Pesan</a>
                                    <form method="POST" action="{{ route('cart.remove', $hotel) }}" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-sm" aria-label="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <aside class="card sticky reveal">
                        <div class="card-title"><i class="fas fa-receipt text-gold"></i> Ringkasan Keranjang</div>
                        <div class="summary-row"><span>Jumlah hotel</span><strong>{{ $hotels->count() }}</strong></div>
                        <div class="summary-row"><span>Estimasi / malam</span><strong>{{ rupiah($hotels->sum('price')) }}</strong></div>
                        <p class="muted small">Pilih tanggal & tipe kamar di langkah berikutnya.</p>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-block btn-lg"><i class="fas fa-bag-shopping"></i> Checkout Semua</a>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
