@extends('layouts.app')

@section('title', 'Kode Pembayaran')

@php $pending = $payment->status === 'pending'; @endphp

@section('content')
    <section class="section-sm">
        <div class="container" style="max-width:980px">
            @include('partials.steps', ['current' => $payment->status === 'paid' ? 5 : 4])

            <div class="detail-layout" style="grid-template-columns:1fr 340px">
                <div class="card reveal" style="display:grid;gap:1.2rem">
                    <div style="display:flex;align-items:center;gap:1rem">
                        <img src="{{ asset('images/'.$payment->method.'_logo.png') }}" alt="" style="width:64px;height:42px;object-fit:contain;background:#fff;border-radius:10px;padding:4px">
                        <div>
                            <h2 style="margin:0;font-size:1.3rem">{{ $payment->methodLabel() }}</h2>
                            <span class="muted small">Kode pembayaran {{ $payment->code }}</span>
                        </div>
                    </div>

                    @if ($pending)
                        <div class="status-banner pending"><i class="fas fa-clock"></i> Menunggu Pembayaran
                            @if ($payment->expires_at)
                                <span style="margin-left:auto" class="countdown" id="countdown" data-expires="{{ $payment->expires_at->toIso8601String() }}">--:--</span>
                            @endif
                        </div>
                    @elseif ($payment->status === 'paid')
                        <div class="status-banner paid"><i class="fas fa-circle-check"></i> Pembayaran Berhasil · {{ $payment->paid_at?->translatedFormat('d M Y H:i') }}</div>
                    @else
                        <div class="status-banner failed"><i class="fas fa-circle-xmark"></i> Pembayaran {{ $payment->status === 'expired' ? 'Kadaluarsa' : 'Dibatalkan' }}</div>
                    @endif

                    @if ($payment->method === 'qris')
                        <div class="qr-wrap"><div class="qr-card"><img src="{{ asset('images/QRIS_Barcode.png') }}" alt="QRIS Barcode"></div></div>
                        <div style="text-align:center" class="muted small">ID Transaksi: <strong>{{ $payment->reference }}</strong> · Merchant: {{ $site['site_title'] }}</div>
                    @elseif ($payment->method === 'bca')
                        <div>
                            <span class="label">Nomor Virtual Account</span>
                            <div class="pay-code" style="margin-top:.4rem">
                                <span id="va-code-value">{{ $payment->reference }}</span>
                                <button class="btn btn-ghost btn-sm" type="button" onclick="navigator.clipboard.writeText(document.getElementById('va-code-value').textContent.trim()).then(() => toast('Nomor VA disalin'))"><i class="fas fa-copy"></i> Salin</button>
                            </div>
                        </div>
                    @else
                        <div class="card" style="background:var(--bg)">
                            <strong>Bayar di tempat saat check-in</strong>
                            @foreach ($payment->bookings as $booking)
                                <p class="muted small" style="margin:.4rem 0 0">{{ $booking->hotel->name }} — {{ $booking->hotel->location }} · check-in {{ $booking->check_in->translatedFormat('d M Y') }} · agen {{ $booking->hotel->agent?->name ?? '-' }} ({{ $booking->hotel->agent?->phone ?? $site['phone'] }})</p>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <strong>Petunjuk pembayaran</strong>
                        <ol class="muted" style="margin:.5rem 0 0;padding-left:1.2rem">
                            @if ($payment->method === 'cod')
                                <li>Datang ke hotel sesuai tanggal check-in.</li><li>Tunjukkan kode pesanan ke resepsionis.</li><li>Bayar tunai dan terima kunci kamar.</li>
                            @elseif ($payment->method === 'qris')
                                <li>Buka aplikasi e-wallet (GoPay, OVO, DANA, dll).</li><li>Pilih "Scan QR" dan scan kode di atas.</li><li>Periksa nominal lalu konfirmasi.</li>
                            @else
                                <li>Salin nomor Virtual Account di atas.</li><li>Buka BCA mobile / KlikBCA → m-Transfer → BCA Virtual Account.</li><li>Tempel nomor VA dan konfirmasi pembayaran.</li>
                            @endif
                        </ol>
                    </div>

                    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                        @if ($pending && config('app.payment_sandbox'))
                            <form method="POST" action="{{ route('payment.confirm', $payment) }}">
                                @csrf
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                    {{ $payment->method === 'cod' ? 'Konfirmasi Pesanan (COD)' : 'Saya Sudah Bayar (simulasi)' }}</button>
                            </form>
                        @endif
                        @if ($payment->status === 'paid')
                            <a href="{{ route('payment.invoice', $payment) }}" class="btn btn-primary"><i class="fas fa-file-invoice"></i> Lihat Invoice</a>
                        @endif
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline">Pesanan Saya</a>
                    </div>
                </div>

                <aside class="card sticky reveal">
                    <div class="card-title"><i class="fas fa-receipt text-gold"></i> Rincian</div>
                    @foreach ($payment->bookings as $booking)
                        <div class="summary-row"><span>{{ $booking->hotel->name }}<br><small>{{ $booking->roomType?->name }} · {{ $booking->nights }} malam</small></span><span>{{ rupiah($booking->total) }}</span></div>
                    @endforeach
                    @if ($payment->discount)
                        <div class="summary-row discount"><span>Diskon {{ $payment->promo_code }}</span><span>− {{ rupiah($payment->discount) }}</span></div>
                    @endif
                    <div class="summary-row total"><span>Total</span><span>{{ rupiah($payment->amount) }}</span></div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        const el = document.getElementById('countdown');
        if (!el) return;
        const end = new Date(el.dataset.expires).getTime();
        const tick = () => {
            const s = Math.max(0, Math.floor((end - Date.now()) / 1000));
            const h = Math.floor(s / 3600), m = Math.floor(s % 3600 / 60), sec = s % 60;
            el.textContent = s === 0 ? 'Kadaluarsa' : (h ? h + ':' : '') + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            if (s === 0) { clearInterval(timer); setTimeout(() => location.reload(), 1500); }
        };
        const timer = setInterval(tick, 1000);
        tick();
    })();
</script>
@endpush
