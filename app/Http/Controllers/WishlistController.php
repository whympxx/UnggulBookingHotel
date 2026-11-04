<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        return view('wishlist.index', [
            'hotels' => $request->user()->wishlist()->active()->with('agent')->withCount('reviews')->latest('wishlists.created_at')->get(),
        ]);
    }

    /** Tambah/hapus hotel dari wishlist (toggle). */
    public function toggle(Request $request, Hotel $hotel): JsonResponse|RedirectResponse
    {
        $result = $request->user()->wishlist()->toggle($hotel->id);
        $added = ! empty($result['attached']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'added' => $added,
                'count' => $request->user()->wishlist()->count(),
            ]);
        }

        return back()->with('success', $added ? $hotel->name.' ditambahkan ke wishlist.' : $hotel->name.' dihapus dari wishlist.');
    }
}
