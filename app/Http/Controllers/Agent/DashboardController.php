<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard agent. Versi lama memakai angka simulasi (12 hotel, 156 booking,
 * Rp 45 juta) dan agent_data.php memakai agent_id default "AGENT1" + field
 * yang tidak ada di orders_data.json.
 */
class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $agent = $request->user();
        $bookings = $this->bookingsOf($request);

        return view('agent.dashboard', [
            'agent' => $agent,
            'totalHotels' => $agent->hotels()->count(),
            'totalBookings' => (clone $bookings)->where('status', '!=', 'cancelled')->count(),
            'totalRevenue' => (clone $bookings)->whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total'),
            'recentBookings' => (clone $bookings)->with('hotel', 'roomType')->latest()->take(50)->get(),
        ]);
    }

    /** Laporan untuk tab "Laporan" (pengganti fetch('orders_data.json')). */
    public function reports(Request $request): JsonResponse
    {
        $type = $request->validate(['type' => ['required', 'in:monthly,revenue']])['type'];
        $paid = ['paid', 'confirmed', 'completed'];

        if ($type === 'monthly') {
            $month = $this->bookingsOf($request)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('check_in', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
                ->with('hotel:id,name')
                ->get();

            return response()->json([
                'total_bookings' => $month->count(),
                'total_revenue' => $month->whereIn('status', $paid)->sum('total'),
                'top_hotel' => $month->groupBy('hotel.name')->sortByDesc(fn ($g) => $g->count())->keys()->first() ?? '-',
            ]);
        }

        $revenue = $this->bookingsOf($request)
            ->whereIn('status', $paid)
            ->with('hotel:id,name')
            ->get()
            ->groupBy('hotel.name')
            ->map(fn ($g) => $g->sum('total'));

        return response()->json(['revenue_per_hotel' => $revenue]);
    }

    private function bookingsOf(Request $request): Builder
    {
        return Booking::query()->whereHas('hotel', fn ($q) => $q->where('agent_id', $request->user()->id));
    }
}
