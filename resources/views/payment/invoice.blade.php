@extends('layouts.app')

@section('title', 'Invoice '.$payment->code)

@section('content')
    <section class="section-sm">
        <div class="container" style="max-width:860px">
            <div class="no-print" style="display:flex;gap:.5rem;justify-content:flex-end;margin-bottom:1rem">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.orders.index') : route('bookings.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Cetak / Simpan PDF</button>
            </div>

            <div class="invoice reveal">
                <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;align-items:flex-start">
                    <div>
                        <div style="display:flex;align-items:center;gap:.6rem">
                            <img src="{{ asset($site['logo'] ?: 'images/logo.png') }}" alt="" style="width:44px;height:44px;border-radius:12px">
                            <strong style="font-size:1.2rem">{{ $site['site_title'] }}</strong>
                        </div>
                        <p style="color:#64748b;font-size:.85rem;margin:.6rem 0 0">{{ $site['address'] }}<br>{{ $site['email'] }} · {{ $site['phone'] }}</p>
                    </div>
                    <div style="text-align:right">
                        <h1 style="margin:0;font-family:var(--font-display)">INVOICE</h1>
                        <div style="color:#64748b;font-size:.9rem">{{ $payment->code }}<br>{{ $payment->created_at->translatedFormat('d F Y') }}</div>
                        <div class="stamp" style="margin-top:.8rem;color:{{ $payment->status === 'paid' ? '#059669' : '#d97706' }}">
                            {{ $payment->status === 'paid' ? 'LUNAS' : strtoupper($payment->status) }}
                        </div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:2rem;font-size:.9rem">
                    <div><strong>Ditagihkan kepada</strong><br>{{ $payment->bookings->first()?->customer_name ?? $payment->user->name }}<br>{{ $payment->bookings->first()?->customer_email }}<br>{{ $payment->bookings->first()?->customer_phone }}</div>
                    <div style="text-align:right"><strong>Metode</strong><br>{{ $payment->methodLabel() }}@if ($payment->reference)<br>Ref: {{ $payment->reference }}@endif
                        @if ($payment->paid_at)<br>Dibayar: {{ $payment->paid_at->translatedFormat('d M Y H:i') }}@endif</div>
                </div>

                <table>
                    <thead><tr><th>Pesanan</th><th>Menginap</th><th style="text-align:right">Subtotal</th><th style="text-align:right">Pajak + Layanan</th><th style="text-align:right">Total</th></tr></thead>
                    <tbody>
                        @foreach ($payment->bookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->hotel->name }}</strong><br><small style="color:#64748b">{{ $booking->code }} · {{ $booking->roomType?->name }} · {{ $booking->guests }} tamu</small></td>
                                <td>{{ $booking->check_in->format('d/m/Y') }} – {{ $booking->check_out->format('d/m/Y') }}<br><small style="color:#64748b">{{ $booking->nights }} malam × {{ rupiah($booking->price_per_night) }}</small></td>
                                <td style="text-align:right">{{ rupiah($booking->subtotal) }}</td>
                                <td style="text-align:right">{{ rupiah($booking->tax + $booking->service_fee) }}</td>
                                <td style="text-align:right">{{ rupiah($booking->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-left:auto;max-width:320px;margin-top:1rem">
                    <div class="summary-row" style="color:#334155"><span>Subtotal</span><span>{{ rupiah($payment->subtotal ?: $payment->amount) }}</span></div>
                    @if ($payment->discount)
                        <div class="summary-row" style="color:#059669"><span>Diskon ({{ $payment->promo_code }})</span><span>− {{ rupiah($payment->discount) }}</span></div>
                    @endif
                    <div class="summary-row total" style="color:#0f172a"><span>Total dibayar</span><span>{{ rupiah($payment->amount) }}</span></div>
                </div>

                <p style="color:#64748b;font-size:.8rem;margin-top:2rem;text-align:center">Tunjukkan invoice ini saat check-in. Terima kasih telah memesan di {{ $site['site_title'] }}.</p>
            </div>
        </div>
    </section>
@endsection
