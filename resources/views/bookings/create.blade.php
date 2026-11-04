@extends('layouts.app')

@section('title', 'Booking '.$hotel->name)

@php $selectedRoom = old('room_type_id', request('room', $hotel->roomTypes->first()?->id)); @endphp

@section('content')
    <section class="section-sm">
        <div class="container">
            @include('partials.steps', ['current' => 2])
            <h1 class="display reveal" style="font-size:clamp(1.8rem,3.5vw,2.5rem)">Lengkapi pemesanan</h1>

            <form action="{{ route('bookings.store', $hotel) }}" method="POST" id="bookingForm" class="detail-layout">
                @csrf
                <div style="display:grid;gap:1.5rem">
                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-bed text-gold"></i> Pilih tipe kamar</div>
                        <div class="choice-grid">
                            @foreach ($hotel->roomTypes as $room)
                                <label class="choice">
                                    <input type="radio" name="room_type_id" value="{{ $room->id }}" data-price="{{ $room->pricePerNight() }}" @checked($selectedRoom == $room->id)>
                                    <span class="box">
                                        <i class="fas {{ $room->price_multiplier >= 2 ? 'fa-crown' : ($room->price_multiplier > 1 ? 'fa-gem' : 'fa-bed') }}" style="font-size:1.4rem;color:var(--brand)"></i>
                                        <span><strong>{{ $room->name }}</strong><small>{{ rupiah($room->pricePerNight()) }} / malam</small></span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('room_type_id') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-user text-gold"></i> Tanggal & data tamu</div>
                        @include('partials.guest-fields')
                    </div>
                </div>

                <aside class="sticky">
                    <div class="card reveal" style="box-shadow:var(--shadow-lg)">
                        <img src="{{ $hotel->imageUrl() }}" alt="{{ $hotel->name }}" style="width:100%;height:160px;object-fit:cover;border-radius:14px;margin-bottom:1rem">
                        <h3 style="margin:0">{{ $hotel->name }}</h3>
                        <div class="meta" style="margin-bottom:1rem"><i class="fas fa-location-dot"></i> {{ $hotel->location }}</div>
                        <div class="summary-row"><span>Harga / malam</span><span id="sumPerNight">-</span></div>
                        <div class="summary-row"><span>Jumlah malam</span><span id="sumNights">-</span></div>
                        <div class="summary-row"><span>Subtotal</span><span id="sumSubtotal">-</span></div>
                        <div class="summary-row"><span>Pajak 10%</span><span id="sumTax">-</span></div>
                        <div class="summary-row"><span>Biaya layanan 1%</span><span id="sumService">-</span></div>
                        <div class="summary-row total"><span>Estimasi total</span><span id="total-price">-</span></div>
                        <p class="muted small">Harga final dihitung oleh sistem. Kode promo bisa dipakai di langkah pembayaran.</p>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjut ke pembayaran <i class="fas fa-arrow-right"></i></button>
                    </div>
                </aside>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('js/booking.js') }}?v=2"></script>
@endpush
