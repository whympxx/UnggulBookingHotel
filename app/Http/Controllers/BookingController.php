<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private BookingService $service) {}

    public function create(Request $request, Hotel $hotel): View
    {
        abort_unless($hotel->status === 'active', 404);

        return view('bookings.create', [
            'hotel' => $hotel->load('roomTypes', 'agent'),
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request, Hotel $hotel): RedirectResponse
    {
        abort_unless($hotel->status === 'active', 404);

        $data = $request->validate(BookingService::rules() + [
            'room_type_id' => ['required', 'integer', 'exists:room_types,id'],
        ]);

        $booking = $this->service->create($request->user(), $hotel, RoomType::findOrFail($data['room_type_id']), $data);

        $request->session()->put('checkout_bookings', [$booking->id]);

        return redirect()->route('payment.create');
    }

    public function index(Request $request): View
    {
        $bookings = $request->user()->bookings()->with('hotel', 'roomType', 'payment')->latest()->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 403);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan yang belum dibayar yang bisa dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan '.$booking->code.' dibatalkan.');
    }
}
