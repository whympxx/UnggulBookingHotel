<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    public const TAX_RATE = 0.10;      // pajak 10%
    public const SERVICE_RATE = 0.01;  // biaya layanan 1%

    public const STATUSES = ['pending', 'paid', 'confirmed', 'completed', 'cancelled'];
    /** Status yang dihitung "memakai" kamar. */
    public const ACTIVE_STATUSES = ['pending', 'paid', 'confirmed'];

    protected $fillable = [
        'code', 'user_id', 'hotel_id', 'room_type_id', 'payment_id',
        'customer_name', 'customer_email', 'customer_phone',
        'check_in', 'check_out', 'nights', 'guests',
        'price_per_night', 'subtotal', 'tax', 'service_fee', 'total',
        'special_requests', 'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->code ??= 'UBH-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        });
    }

    /**
     * Hitung rincian harga. Dipakai di server supaya harga tidak bisa
     * dimanipulasi dari browser (bug di versi lama).
     *
     * @return array{nights:int, price_per_night:int, subtotal:int, tax:int, service_fee:int, total:int}
     */
    public static function quote(RoomType $roomType, CarbonInterface $checkIn, CarbonInterface $checkOut): array
    {
        $nights = max(1, (int) $checkIn->copy()->startOfDay()->diffInDays($checkOut->copy()->startOfDay()));
        $perNight = $roomType->pricePerNight();
        $subtotal = $perNight * $nights;
        $tax = (int) round($subtotal * self::TAX_RATE);
        $service = (int) round($subtotal * self::SERVICE_RATE);

        return [
            'nights' => $nights,
            'price_per_night' => $perNight,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'service_fee' => $service,
            'total' => $subtotal + $tax + $service,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
