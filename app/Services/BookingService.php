<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /** Aturan validasi data tamu & tanggal (dipakai booking satuan dan checkout keranjang). */
    public static function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,30}$/'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:4'],
            'special_requests' => ['nullable', 'string', 'max:500'],
        ];
    }

    /** Jumlah kamar tersisa untuk rentang tanggal tertentu. */
    public function availableRooms(RoomType $roomType, Carbon $checkIn, Carbon $checkOut): int
    {
        $taken = $roomType->bookings()
            ->whereIn('status', Booking::ACTIVE_STATUSES)
            ->whereDate('check_in', '<', $checkOut->toDateString())
            ->whereDate('check_out', '>', $checkIn->toDateString())
            ->count();

        return max(0, $roomType->total_rooms - $taken);
    }

    /**
     * Buat booking berstatus pending. Harga selalu dihitung ulang di server.
     *
     * @param array<string, mixed> $data hasil validasi rules()
     */
    public function create(User $user, Hotel $hotel, RoomType $roomType, array $data, string $errorKey = 'room_type_id'): Booking
    {
        if ($roomType->hotel_id !== $hotel->id) {
            throw ValidationException::withMessages([$errorKey => 'Tipe kamar tidak valid untuk hotel ini.']);
        }

        $checkIn = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);

        if ($this->availableRooms($roomType, $checkIn, $checkOut) < 1) {
            throw ValidationException::withMessages([
                $errorKey => "Kamar {$roomType->name} di {$hotel->name} sudah penuh pada tanggal tersebut.",
            ]);
        }

        return Booking::create(Booking::quote($roomType, $checkIn, $checkOut) + [
            'user_id' => $user->id,
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomType->id,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'guests' => $data['guests'],
            'special_requests' => $data['special_requests'] ?? null,
            'status' => 'pending',
        ]);
    }
}
