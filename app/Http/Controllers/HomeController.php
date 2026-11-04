<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $hotels = Hotel::active()->with('agent')->withCount('reviews')->orderByDesc('rating')->orderBy('name')->get();

        return view('pages.home', [
            'hotels' => $hotels->take(8),
            'popular' => $hotels->sortByDesc('price')->take(3),
            'locations' => $this->locationOptions(),
            'destinations' => $this->destinations($hotels),
            'stats' => [
                'hotels' => $hotels->count(),
                'cities' => count($this->locationOptions()),
                'guests' => Booking::where('status', '!=', 'cancelled')->sum('guests'),
                'rating' => round((float) $hotels->avg('rating'), 1),
            ],
            'testimonials' => Review::with('user', 'hotel')->whereNotNull('comment')->where('rating', '>=', 4)->latest()->take(3)->get(),
            'wishlistIds' => $this->wishlistIds($request),
        ]);
    }

    /** Pencarian live di beranda (pengganti search_hotels.php). */
    public function search(Request $request): JsonResponse
    {
        $filters = $this->validateFilters($request);

        $hotels = Hotel::active()->with('agent')->withCount('reviews')
            ->filter($filters)
            ->get()
            ->map->toCardArray();

        return response()->json($hotels);
    }

    /** Halaman jelajah hotel dengan filter harga, rating & urutan. */
    public function services(Request $request): View
    {
        $filters = $this->validateFilters($request);

        return view('pages.services', [
            'hotels' => Hotel::active()->with('agent')->withCount('reviews')->filter($filters)->get(),
            'filters' => $filters,
            'locations' => $this->locationOptions(),
            'priceRange' => [(int) Hotel::active()->min('price'), (int) Hotel::active()->max('price')],
            'wishlistIds' => $this->wishlistIds($request),
        ]);
    }

    public function properties(Request $request): View
    {
        $hotels = Hotel::active()->with('agent')->withCount('reviews')->orderByDesc('rating')->get();

        return view('pages.properties', [
            'featured' => $hotels->take(3),
            'hotels' => $hotels,
            'wishlistIds' => $this->wishlistIds($request),
        ]);
    }

    public function agents(): View
    {
        $agents = User::where('role', User::ROLE_AGENT)
            ->with(['hotels' => fn ($q) => $q->active()->withCount('reviews')])
            ->orderBy('name')
            ->get();

        return view('pages.agents', compact('agents'));
    }

    private function validateFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'integer', 'min:0'],
            'max_price' => ['nullable', 'integer', 'min:0'],
            'min_rating' => ['nullable', 'numeric', 'between:0,5'],
            'sort' => ['nullable', 'in:rating,price_asc,price_desc,name'],
        ]);
    }

    /** @return list<int> */
    private function wishlistIds(Request $request): array
    {
        $user = $request->user();

        return $user && $user->role === User::ROLE_USER ? $user->wishlist()->pluck('hotels.id')->all() : [];
    }

    /** Destinasi populer: kota + jumlah hotel + foto. */
    private function destinations($hotels): array
    {
        return $hotels->groupBy(fn ($h) => $this->cityOf($h->location))
            ->map(fn ($group, $city) => ['city' => $city, 'count' => $group->count(), 'image' => $group->first()->imageUrl()])
            ->sortByDesc('count')->take(6)->values()->all();
    }

    private function cityOf(string $location): string
    {
        $city = trim(preg_replace('/^Kota\s+/i', '', trim(last(explode(',', $location)))));

        return str_starts_with($city, 'Jakarta') ? 'Jakarta' : $city;
    }

    /** Pilihan lokasi diambil dari data hotel (bukan hardcode). */
    private function locationOptions(): array
    {
        return Hotel::active()->pluck('location')
            ->map(fn ($l) => $this->cityOf($l))
            ->unique()->sort()->values()->all();
    }
}
