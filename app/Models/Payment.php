<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Payment extends Model
{
    public const METHODS = [
        'bca' => 'BCA Virtual Account',
        'qris' => 'QRIS',
        'cod' => 'Bayar di Tempat',
    ];

    protected $fillable = ['code', 'user_id', 'method', 'subtotal', 'discount', 'promo_code', 'amount', 'reference', 'status', 'expires_at', 'paid_at'];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'subtotal' => 'integer',
            'discount' => 'integer',
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            $payment->code ??= 'PAY-'.now()->format('ymdHis').'-'.Str::upper(Str::random(4));
        });
    }

    /** Buat nomor referensi + batas waktu sesuai metode. */
    public static function referenceFor(string $method): array
    {
        return match ($method) {
            // 39xxx = kode perusahaan dummy BCA VA, total 16 digit
            'bca' => ['reference' => '39'.str_pad((string) random_int(0, 99999999999999), 14, '0', STR_PAD_LEFT), 'expires_at' => now()->addDay()],
            'qris' => ['reference' => 'TRX'.now()->format('YmdHis').random_int(1000, 9999), 'expires_at' => now()->addMinutes(15)],
            default => ['reference' => null, 'expires_at' => null],
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function methodLabel(): string
    {
        return self::METHODS[$this->method] ?? strtoupper($this->method);
    }

    public function isExpired(): bool
    {
        return $this->status === 'pending' && $this->expires_at && $this->expires_at->isPast();
    }
}
