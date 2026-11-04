<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Kelola kamar per hotel. Versi lama hanya demo (tidak tersimpan). */
class RoomController extends Controller
{
    public function index(): View
    {
        $hotels = Hotel::with('roomTypes')->orderBy('name')->get();

        $chart = $hotels->map(function (Hotel $hotel) {
            $used = $hotel->roomTypes->sum(fn ($r) => $r->occupiedCount());

            return ['name' => $hotel->name, 'total' => $hotel->totalRooms(), 'available' => $hotel->totalRooms() - $used, 'occupied' => $used];
        });

        return view('admin.rooms', compact('hotels', 'chart'));
    }

    public function store(Request $request, Hotel $hotel): RedirectResponse
    {
        $hotel->roomTypes()->create($this->validated($request));

        return back()->with('success', 'Tipe kamar ditambahkan ke '.$hotel->name.'.');
    }

    public function update(Request $request, RoomType $room): RedirectResponse
    {
        $room->update($this->validated($request));

        return back()->with('success', 'Tipe kamar diperbarui.');
    }

    public function destroy(RoomType $room): RedirectResponse
    {
        $room->delete();

        return back()->with('success', 'Tipe kamar dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'total_rooms' => ['required', 'integer', 'min:1', 'max:1000'],
            'price_multiplier' => ['required', 'numeric', 'min:0.5', 'max:10'],
        ]);
    }
}
