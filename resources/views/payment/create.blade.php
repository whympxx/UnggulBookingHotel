@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <section class="section-sm">
        <div class="container">
            @include('partials.steps', ['current' => 3])
            <h1 class="display reveal" style="font-size:clamp(1.8rem,3.5vw,2.5rem)">Informasi Pemesanan</h1>

            <div class="detail-layout">
                <div style="display:grid;gap:1.5rem">
                    @foreach ($bookings as $booking)
                        <div class="card reveal" style="display:flex;gap:1.2rem;flex-wrap:wrap">
                            <img src="{{ $booking->hotel->imageUrl() }}" alt="{{ $booking->hotel->name }}" style="width:180px;height:130px;object-fit:cover;border-radius:14px">
                            <div style="flex:1;min-width:220px">
                                <h3 style="margin:0">{{ $booking->hotel->name }}</h3>
                                <div class="meta"><i class="fas fa-location-dot"></i> {{ $booking->hotel->location }}</div>
                                <div class="chips" style="margin:.6rem 0">
                                    <span class="chip"><i class="fas fa-calendar"></i> {{ $booking->check_in->translatedFormat('D, d M Y') }} → {{ $booking->check_out->translatedFormat('D, d M Y') }}</span>
                                    <span class="chip"><i class="fas fa-bed"></i> {{ $booking->roomType?->name ?? '-' }}</span>
                                    <span class="chip"><i class="fas fa-user"></i> {{ $booking->guests }} tamu</span>
                                </div>
                                <div class="summary-row"><span>{{ rupiah($booking->price_per_night) }} × {{ $booking->nights }} malam</span><span>{{ rupiah($booking->subtotal) }}</span></div>
                                <div class="summary-row"><span>Pajak 10%</span><span>{{ rupiah($booking->tax) }}</span></div>
                                <div class="summary-row"><span>Biaya layanan 1%</span><span>{{ rupiah($booking->service_fee) }}</span></div>
                                <div class="summary-row" style="color:var(--text);font-weight:600"><span>Total ({{ $booking->code }})</span><span>{{ rupiah($booking->total) }}</span></div>
                            </div>
                        </div>
                    @endforeach

                    <div class="card reveal">
                        <div class="card-title"><i class="fas fa-user text-gold"></i> Data Pemesan</div>
                        <div class="summary-row"><span>Nama</span><strong style="color:var(--text)">{{ $bookings->first()->customer_name }}</strong></div>
                        <div class="summary-row"><span>Email</span><strong style="color:var(--text)">{{ $bookings->first()->customer_email }}</strong></div>
                        <div class="summary-row"><span>Telepon</span><strong style="color:var(--text)">{{ $bookings->first()->customer_phone }}</strong></div>
                        @if ($bookings->first()->special_requests)
                            <div class="summary-row"><span>Permintaan khusus</span><strong style="color:var(--text)">{{ $bookings->first()->special_requests }}</strong></div>
                        @endif
                    </div>
                </div>

                <aside class="sticky" style="display:grid;gap:1rem">
                    {{-- Promo (preview lewat GET) --}}
                    <form method="GET" action="{{ route('payment.create') }}" class="card reveal">
                        <div class="card-title"><i class="fas fa-ticket text-gold"></i> Kode promo</div>
                        <div style="display:flex;gap:.5rem">
                            <input class="input" name="promo" value="{{ $promoCode }}" placeholder="mis. WELCOME10" style="text-transform:uppercase" aria-label="Kode promo">
                            <button class="btn btn-ghost" type="submit">Pakai</button>
                        </div>
                        @if ($promoError)
                            <span class="field-error" style="display:block;margin-top:.5rem">{{ $promoError }}</span>
                        @elseif ($promo)
                            <span class="small" style="color:var(--success);display:block;margin-top:.5rem"><i class="fas fa-circle-check"></i> {{ $promo->code }}: {{ $promo->description ?: 'potongan '.$promo->label() }}</span>
                        @endif
                        @error('promo_code') <span class="field-error">{{ $message }}</span> @enderror
                    </form>

                    <form method="POST" action="{{ route('payment.store') }}" class="card reveal" style="box-shadow:var(--shadow-lg)">
                        @csrf
                        <input type="hidden" name="promo_code" value="{{ $promo?->code }}">
                        <div class="card-title"><i class="fas fa-wallet text-gold"></i> Metode pembayaran</div>
                        <div style="display:grid;gap:.6rem">
                            @foreach (['bca' => ['bca_logo.png', 'Virtual Account, otomatis terverifikasi'], 'qris' => ['qris_logo.png', 'Scan pakai e-wallet apa saja'], 'cod' => ['cod_logo.png', 'Bayar tunai saat check-in']] as $value => [$logo, $caption])
                                <label class="choice">
                                    <input type="radio" name="method" value="{{ $value }}" @checked(old('method', 'bca') === $value)>
                                    <span class="box">
                                        <img src="{{ asset('images/'.$logo) }}" alt="">
                                        <span><strong>{{ $methods[$value] }}</strong><small>{{ $caption }}</small></span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <div style="margin-top:1rem">
                            <div class="summary-row"><span>Subtotal</span><span>{{ rupiah($total) }}</span></div>
                            @if ($discount)
                                <div class="summary-row discount"><span>Diskon {{ $promo->code }}</span><span>− {{ rupiah($discount) }}</span></div>
                            @endif
                            <div class="summary-row total"><span>Total Harga</span><span>{{ rupiah($total - $discount) }}</span></div>
                            <p class="muted small">Termasuk pajak 10% dan biaya layanan 1%.</p>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fas fa-lock"></i> Pesan Sekarang</button>
                    </form>
                </aside>
            </div>
        </div>
    </section>
@endsection
