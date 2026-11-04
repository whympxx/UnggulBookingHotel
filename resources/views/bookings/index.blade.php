@extends('layouts.app')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')
@section('page-subtitle', 'Pantau status pembayaran dan riwayat menginap Anda.')

@section('content')
    <section class="section-sm">
        <div class="container">
            @if ($bookings->isEmpty())
                <div class="empty card reveal">
                    <i class="fas fa-suitcase-rolling"></i>
                    <h3>Belum ada pesanan</h3>
                    <a href="{{ route('services') }}" class="btn btn-primary">Cari hotel</a>
                </div>
            @else
                <div style="display:grid;gap:1rem">
                    @foreach ($bookings as $booking)
                        <div class="card reveal" style="display:grid;grid-template-columns:140px 1fr auto;gap:1.2rem;align-items:center;padding:1rem" data-tilt="2">
                            <img src="{{ $booking->hotel?->imageUrl() ?? asset('images/default-hotel.jpg') }}" alt="" style="width:140px;height:100px;object-fit:cover;border-radius:14px">
                            <div>
                                <div style="display:flex;gap:.6rem;align-items:center;flex-wrap:wrap">
                                    <h3 style="margin:0;font-size:1.05rem">
                                        @if ($booking->hotel)<a href="{{ route('hotels.show', $booking->hotel) }}" style="color:var(--text)">{{ $booking->hotel->name }}</a>@else (hotel dihapus) @endif
                                    </h3>
                                    <span class="badge badge-{{ $booking->status }}">{{ $booking->statusLabel() }}</span>
                                </div>
                                <div class="meta"><i class="fas fa-hashtag"></i> {{ $booking->code }} · {{ $booking->roomType?->name ?? '-' }} · {{ $booking->guests }} tamu</div>
                                <div class="meta"><i class="fas fa-calendar"></i> {{ $booking->check_in->translatedFormat('d M Y') }} → {{ $booking->check_out->translatedFormat('d M Y') }} ({{ $booking->nights }} malam)</div>
                                <strong>{{ rupiah($booking->total) }}</strong>
                            </div>
                            <div class="actions" style="flex-direction:column;align-items:stretch">
                                @if ($booking->status === 'pending')
                                    @if ($booking->payment && $booking->payment->status === 'pending')
                                        <a href="{{ route('payment.show', $booking->payment) }}" class="btn btn-primary btn-sm"><i class="fas fa-wallet"></i> Lihat Pembayaran</a>
                                    @else
                                        <a href="{{ route('payment.create', ['booking' => $booking->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-wallet"></i> Bayar</a>
                                    @endif
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                                        @csrf
                                        <button class="btn btn-outline btn-sm btn-block" type="submit">Batal</button>
                                    </form>
                                @endif
                                @if ($booking->payment && $booking->payment->status === 'paid')
                                    <a href="{{ route('payment.invoice', $booking->payment) }}" class="btn btn-ghost btn-sm"><i class="fas fa-file-invoice"></i> Invoice</a>
                                @endif
                                @if (in_array($booking->status, ['paid', 'confirmed', 'completed']) && $booking->hotel)
                                    <a href="{{ route('hotels.show', $booking->hotel) }}#reviews" class="btn btn-outline btn-sm"><i class="fas fa-star"></i> Beri ulasan</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $bookings->links() }}
            @endif
        </div>
    </section>
    <style>@media (max-width: 700px) { .card[data-tilt="2"] { grid-template-columns: 1fr !important; } .card[data-tilt="2"] img { width: 100% !important; height: 160px !important; } }</style>
@endsection
