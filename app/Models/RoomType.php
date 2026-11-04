<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    /** Tipe kamar bawaan + pengali harga (sama seperti versi lama). */
    public const DEFAULTS = [
        ['name' => 'Standard Room', 'price_multiplier' => 1.0, 'total_rooms' => 10],
        ['name' => 'Deluxe Room', 'price_multiplier' => 1.5, 'total_rooms' => 5],
        ['name' => 'Suite Room', 'price_multiplier' => 2.0, 'total_rooms' => 2],
    ];

    protected $fillable = ['hotel_id', 'name', 'price_multiplier', 'total_rooms'];

    protected function casts(): array
    {
        return [
            'price_multiplier' => 'float',
            'total_rooms' => 'integer',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function pricePerNight(): int
    {
        return (int) round($this->hotel->price * $this->price_multiplier);
    }

    /** Jumlah kamar yang sedang terpakai hari ini (booking aktif). */
    public function occupiedCount(): int
    {
        $today = now()->toDateString();

        $count = $this->bookings()
            ->whereIn('status', Booking::ACTIVE_STATUSES)
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->count();

        return min($count, $this->total_rooms);
    }
}
