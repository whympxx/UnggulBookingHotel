<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Pengganti payment.php + va_code.php. Versi lama mengambil harga & nama hotel
 * dari URL (bisa diubah user), memakai pajak tetap Rp 522.500 padahal tertulis
 * 10% + 1%, dan "Checkout Semua" tidak pernah menyimpan pesanan.
 */
class PaymentController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        // Tombol "Bayar" dari halaman Pesanan Saya
        if ($request->filled('booking')) {
            $request->session()->put('checkout_bookings', [(int) $request->query('booking')]);
        }

        $bookings = $this->pendingCheckout($request);
        if ($bookings->isEmpty()) {
            return redirect()->route('bookings.index')->with('error', 'Tidak ada pesanan yang menunggu pembayaran.');
        }

        $total = (int) $bookings->sum('total');
        $promoCode = $request->query('promo');
        [$promo, $promoError] = $this->resolvePromo($promoCode, $total);

        return view('payment.create', [
            'bookings' => $bookings,
            'total' => $total,
            'promo' => $promo,
            'promoCode' => $promoCode,
            'promoError' => $promoError,
            'discount' => $promo?->discountFor($total) ?? 0,
            'methods' => Payment::METHODS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'method' => ['required', Rule::in(array_keys(Payment::METHODS))],
            'bookings' => ['nullable', 'array'],
            'bookings.*' => ['integer'],
            'promo_code' => ['nullable', 'string', 'max:30'],
        ]);

        // Bisa dari session checkout atau tombol "Bayar" di halaman Pesanan Saya
        if (! empty($data['bookings'])) {
            $request->session()->put('checkout_bookings', $data['bookings']);
        }
        $bookings = $this->pendingCheckout($request);
        if ($bookings->isEmpty()) {
            return redirect()->route('bookings.index')->with('error', 'Pesanan tidak ditemukan atau sudah dibayar.');
        }

        $subtotal = (int) $bookings->sum('total');
        [$promo, $promoError] = $this->resolvePromo($data['promo_code'] ?? null, $subtotal);
        if ($promoError) {
            return redirect()->route('payment.create')->withErrors(['promo_code' => $promoError]);
        }
        $discount = $promo?->discountFor($subtotal) ?? 0;

        $payment = DB::transaction(function () use ($request, $bookings, $data, $promo, $subtotal, $discount) {
            $promo?->increment('used');

            $payment = Payment::create(Payment::referenceFor($data['method']) + [
                'user_id' => $request->user()->id,
                'method' => $data['method'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'promo_code' => $promo?->code,
                'amount' => $subtotal - $discount,
                'status' => 'pending',
            ]);
            Booking::whereIn('id', $bookings->pluck('id'))->update(['payment_id' => $payment->id]);

            return $payment;
        });

        $request->session()->forget('checkout_bookings');

        return redirect()->route('payment.show', $payment);
    }

    public function show(Request $request, Payment $payment): View
    {
        abort_unless($payment->user_id === $request->user()->id, 403);

        if ($payment->isExpired()) {
            $payment->update(['status' => 'expired']);
            // kuota promo dikembalikan
            Promo::findByCode($payment->promo_code)?->decrement('used');
            $payment->bookings()->where('status', 'pending')->update(['status' => 'cancelled', 'payment_id' => null]);
        }

        return view('payment.show', [
            'payment' => $payment->load('bookings.hotel.agent', 'bookings.roomType'),
        ]);
    }

    /**
     * Simulasi konfirmasi pembayaran (mode sandbox) karena belum ada payment
     * gateway sungguhan. Untuk COD, pesanan langsung dikonfirmasi.
     */
    public function confirm(Request $request, Payment $payment): RedirectResponse
    {
        abort_unless($payment->user_id === $request->user()->id, 403);
        abort_unless(config('app.payment_sandbox'), 403, 'Mode sandbox pembayaran tidak aktif.');

        if ($payment->status !== 'pending' || $payment->isExpired()) {
            return back()->with('error', 'Pembayaran ini sudah tidak bisa dikonfirmasi.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'paid', 'paid_at' => now()]);
            $payment->bookings()->update(['status' => $payment->method === 'cod' ? 'confirmed' : 'paid']);
        });

        return redirect()->route('bookings.index')->with('success', 'Pembayaran '.$payment->code.' berhasil dikonfirmasi.');
    }

    /** Invoice / e-ticket yang bisa dicetak. */
    public function invoice(Request $request, Payment $payment): View
    {
        abort_unless($payment->user_id === $request->user()->id || $request->user()->isAdmin(), 403);

        return view('payment.invoice', [
            'payment' => $payment->load('user', 'bookings.hotel', 'bookings.roomType'),
        ]);
    }

    /**
     * @return array{0: ?Promo, 1: ?string} [promo valid, pesan error]
     */
    private function resolvePromo(?string $code, int $amount): array
    {
        if (blank($code)) {
            return [null, null];
        }
        $promo = Promo::findByCode($code);
        if (! $promo) {
            return [null, 'Kode promo tidak ditemukan.'];
        }
        $reason = $promo->invalidReason($amount);

        return $reason ? [null, $reason] : [$promo, null];
    }

    /** @return Collection<int, Booking> */
    private function pendingCheckout(Request $request): Collection
    {
        $ids = $request->session()->get('checkout_bookings', []);

        return Booking::with('hotel', 'roomType')
            ->whereIn('id', $ids)
            ->where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->whereNull('payment_id')
            ->get();
    }
}
