<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use App\Support\ImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Versi lama: angka total kamar (36) dan agent (5) di-hardcode, dan
 * admin_dashboard_data.php meng-include admin_properties.php yang mencetak
 * HTML sehingga respons JSON-nya selalu rusak (grafik realtime tidak jalan).
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', ['stats' => $this->stats()]);
    }

    public function data(): JsonResponse
    {
        return response()->json($this->stats());
    }

    public function uploadPhoto(Request $request): JsonResponse
    {
        $request->validate([
            'profile_img' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $user = $request->user();
        ImageUpload::delete($user->avatar);
        $user->update(['avatar' => ImageUpload::store($request->file('profile_img'), 'avatars')]);

        return response()->json(['success' => true, 'url' => $user->avatarUrl()]);
    }

    private function stats(): array
    {
        $hotels = Hotel::with('roomTypes')->get();

        $perHotel = $hotels->map(function (Hotel $hotel) {
            $total = $hotel->totalRooms();
            $used = $hotel->roomTypes->sum(fn ($room) => $room->occupiedCount());

            return ['hotel' => $hotel->name, 'tersedia' => $total - $used, 'dipakai' => $used];
        });

        return [
            'locations' => $hotels->pluck('location')->map(fn ($l) => mb_strtolower(trim($l)))->unique()->count(),
            'property' => $hotels->count(),
            'orders' => Booking::count(),
            'agent' => User::where('role', User::ROLE_AGENT)->count(),
            'kamar' => $hotels->sum(fn ($h) => $h->totalRooms()),
            'kamar_tersedia' => $perHotel->sum('tersedia'),
            'kamar_dipakai' => $perHotel->sum('dipakai'),
            'kamar_per_hotel' => $perHotel->values(),
            'revenue' => (int) Booking::whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total'),
            'pending_orders' => Booking::where('status', 'pending')->count(),
            'revenue_monthly' => $this->monthlyRevenue(),
        ];
    }

    /** Pendapatan 6 bulan terakhir (berdasarkan tanggal pesanan dibuat). */
    private function monthlyRevenue(): array
    {
        $paid = Booking::whereIn('status', ['paid', 'confirmed', 'completed'])
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->get(['total', 'created_at'])
            ->groupBy(fn ($b) => $b->created_at->format('Y-m'));

        return collect(range(5, 0))->map(function ($i) use ($paid) {
            $month = now()->subMonths($i);

            return ['label' => $month->translatedFormat('M Y'), 'total' => (int) ($paid->get($month->format('Y-m'))?->sum('total') ?? 0)];
        })->all();
    }
}
