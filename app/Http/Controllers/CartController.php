<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Keranjang disimpan di session server. Versi lama mencampur localStorage
 * (tampilan) dan $_SESSION (checkout) sehingga datanya sering tidak sinkron,
 * dan "checkout semua" tidak menyimpan pesanan sama sekali.
 */
class CartController extends Controller
{
    public function __construct(private BookingService $service) {}

    public function index(Request $request): View
    {
        return view('cart.index', ['hotels' => $this->cartHotels($request)]);
    }

    public function add(Request $request, Hotel $hotel): RedirectResponse|JsonResponse
    {
        $cart = collect($request->session()->get('cart', []));
        if (! $cart->contains($hotel->id)) {
            $cart->push($hotel->id);
        }
        $request->session()->put('cart', $cart->values()->all());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'count' => $cart->count()]);
        }

        return redirect()->route('cart.index')->with('success', $hotel->name.' ditambahkan ke keranjang.');
    }

    public function remove(Request $request, Hotel $hotel): RedirectResponse
    {
        $cart = collect($request->session()->get('cart', []))->reject(fn ($id) => $id === $hotel->id);
        $request->session()->put('cart', $cart->values()->all());

        return back()->with('success', $hotel->name.' dihapus dari keranjang.');
    }

    public function checkoutForm(Request $request): View|RedirectResponse
    {
        $hotels = $this->cartHotels($request);
        if ($hotels->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('cart.checkout', ['hotels' => $hotels, 'user' => $request->user()]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $hotels = $this->cartHotels($request);
        if ($hotels->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $data = $request->validate(BookingService::rules() + [
            'rooms' => ['required', 'array'],
            'rooms.*' => ['required', 'integer', 'exists:room_types,id'],
        ]);

        $ids = DB::transaction(function () use ($hotels, $data, $request) {
            return $hotels->map(function (Hotel $hotel) use ($data, $request) {
                $roomType = RoomType::find($data['rooms'][$hotel->id] ?? null);
                abort_unless($roomType, 422, 'Pilih tipe kamar untuk '.$hotel->name);

                return $this->service->create($request->user(), $hotel, $roomType, $data, 'rooms.'.$hotel->id)->id;
            })->all();
        });

        $request->session()->put('checkout_bookings', $ids);
        $request->session()->forget('cart');

        return redirect()->route('payment.create');
    }

    /** @return Collection<int, Hotel> */
    private function cartHotels(Request $request): Collection
    {
        $ids = $request->session()->get('cart', []);

        return Hotel::active()->with('roomTypes', 'agent')->whereIn('id', $ids)->get();
    }
}
