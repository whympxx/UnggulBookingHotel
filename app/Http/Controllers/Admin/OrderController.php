<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Versi lama: hapus order lewat link GET (?delete=), edit total sebagai teks
 * bebas, dan ID order dihitung dari count()+1 (bisa dobel setelah hapus).
 */
class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Booking::with('hotel', 'roomType', 'payment')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('code', 'like', '%'.$request->q.'%')
                ->orWhere('customer_name', 'like', '%'.$request->q.'%')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders', [
            'orders' => $orders,
            'editing' => $request->filled('edit') ? Booking::find($request->integer('edit')) : null,
            'statuses' => Booking::STATUSES,
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'status' => ['required', 'in:'.implode(',', Booking::STATUSES)],
        ]);

        $datesChanged = $data['check_in'] !== $booking->check_in->toDateString()
            || $data['check_out'] !== $booking->check_out->toDateString();

        $booking->fill($data);
        if ($datesChanged && $booking->roomType) {
            // total dihitung ulang, tidak diketik manual
            $booking->fill(Booking::quote($booking->roomType, $booking->check_in, $booking->check_out));
        }
        $booking->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order '.$booking->code.' diperbarui.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order dihapus.');
    }
}
