@extends('layouts.app')

@section('title', 'Checkout Semua')

@section('content')
    <section class="section-sm">
        <div class="container">
            @include('partials.steps', ['current' => 2])
            <h1 class="display reveal" style="font-size:clamp(1.8rem,3.5vw,2.5rem)">Checkout {{ $hotels->count() }} hotel</h1>

            <form action="{{ route('cart.checkout.store') }}" method="POST" class="detail-layout">
                @csrf
                <div style="display:grid;gap:1.5rem">
                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-bed text-gold"></i> Tipe kamar per hotel</div>
                        @foreach ($hotels as $hotel)
                            <div class="room-row">
                                <div style="display:flex;gap:.8rem;align-items:center">
                                    <img src="{{ $hotel->imageUrl() }}" alt="" class="thumb">
                                    <div><strong>{{ $hotel->name }}</strong><br><span class="muted small">{{ $hotel->location }}</span></div>
                                </div>
                                <div class="field" style="min-width:220px">
                                    <select id="room-{{ $hotel->id }}" name="rooms[{{ $hotel->id }}]" required aria-label="Tipe kamar {{ $hotel->name }}">
                                        @foreach ($hotel->roomTypes as $room)
                                            <option value="{{ $room->id }}" data-price="{{ $room->pricePerNight() }}" @selected(old('rooms.'.$hotel->id) == $room->id)>
                                                {{ $room->name }} — {{ rupiah($room->pricePerNight()) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rooms.'.$hotel->id) <span class="field-error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-user text-gold"></i> Tanggal & data tamu (berlaku untuk semua hotel)</div>
                        @include('partials.guest-fields')
                    </div>
                </div>
                <aside class="sticky">
                    <div class="card reveal" style="box-shadow:var(--shadow-lg)">
                        <div class="card-title"><i class="fas fa-receipt text-gold"></i> Estimasi</div>
                        <div class="summary-row"><span>Total / malam</span><span id="sumPerNight">-</span></div>
                        <div class="summary-row"><span>Jumlah malam</span><span id="sumNights">-</span></div>
                        <div class="summary-row"><span>Subtotal</span><span id="sumSubtotal">-</span></div>
                        <div class="summary-row"><span>Pajak 10%</span><span id="sumTax">-</span></div>
                        <div class="summary-row"><span>Biaya layanan 1%</span><span id="sumService">-</span></div>
                        <div class="summary-row total"><span>Estimasi total</span><span id="total-price">-</span></div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjut ke Pembayaran <i class="fas fa-arrow-right"></i></button>
                    </div>
                </aside>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('js/booking.js') }}?v=2"></script>
@endpush
