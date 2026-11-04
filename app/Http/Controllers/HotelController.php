<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Halaman detail hotel + ulasan + wishlist. */
class HotelController extends Controller
{
    public function show(Request $request, Hotel $hotel): View
    {
        abort_unless($hotel->status === 'active', 404);

        $hotel->load(['agent', 'roomTypes', 'reviews' => fn ($q) => $q->with('user')->latest()]);
        $user = $request->user();

        return view('hotels.show', [
            'hotel' => $hotel,
            'canReview' => $user && $this->hasStayed($user->id, $hotel),
            'myReview' => $user ? $hotel->reviews->firstWhere('user_id', $user->id) : null,
            'inWishlist' => $user && $user->wishlist()->whereKey($hotel->id)->exists(),
            'similar' => Hotel::active()->with('agent')->withCount('reviews')
                ->whereKeyNot($hotel->id)
                ->where(fn ($q) => $q->where('agent_id', $hotel->agent_id)->orWhere('location', 'like', '%'.last(explode(' ', $hotel->location)).'%'))
                ->orderByDesc('rating')->take(3)->get(),
            'ratingBreakdown' => collect(range(5, 1))->mapWithKeys(fn ($r) => [$r => $hotel->reviews->where('rating', $r)->count()]),
        ]);
    }

    /** Simpan/perbarui ulasan. Hanya untuk tamu yang sudah membayar/menginap. */
    public function review(Request $request, Hotel $hotel): RedirectResponse
    {
        abort_unless($this->hasStayed($request->user()->id, $hotel), 403, 'Ulasan hanya untuk tamu yang sudah memesan hotel ini.');

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $hotel->reviews()->updateOrCreate(['user_id' => $request->user()->id], $data);

        return redirect()->to(route('hotels.show', $hotel).'#reviews')->with('success', 'Terima kasih, ulasan Anda tersimpan.');
    }

    public function destroyReview(Request $request, Hotel $hotel): RedirectResponse
    {
        $hotel->reviews()->where('user_id', $request->user()->id)->first()?->delete();

        return redirect()->to(route('hotels.show', $hotel).'#reviews')->with('success', 'Ulasan dihapus.');
    }

    private function hasStayed(int $userId, Hotel $hotel): bool
    {
        return Booking::where('user_id', $userId)
            ->where('hotel_id', $hotel->id)
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->exists();
    }
}
