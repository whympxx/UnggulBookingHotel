<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code', 'description', 'type', 'value', 'max_discount',
        'min_amount', 'max_uses', 'used', 'expires_at', 'active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'max_discount' => 'integer',
            'min_amount' => 'integer',
            'max_uses' => 'integer',
            'used' => 'integer',
            'expires_at' => 'datetime',
            'active' => 'boolean',
        ];
    }

    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    public static function findByCode(?string $code): ?self
    {
        return filled($code) ? static::where('code', strtoupper(trim($code)))->first() : null;
    }

    /** Alasan promo tidak bisa dipakai, atau null jika valid. */
    public function invalidReason(int $amount): ?string
    {
        return match (true) {
            ! $this->active => 'Kode promo tidak aktif.',
            $this->expires_at && $this->expires_at->isPast() => 'Kode promo sudah kadaluarsa.',
            $this->max_uses !== null && $this->used >= $this->max_uses => 'Kuota kode promo sudah habis.',
            $amount < $this->min_amount => 'Minimal transaksi '.rupiah($this->min_amount).' untuk kode ini.',
            default => null,
        };
    }

    public function discountFor(int $amount): int
    {
        $discount = $this->type === 'percent'
            ? (int) round($amount * $this->value / 100)
            : $this->value;

        if ($this->type === 'percent' && $this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return min($discount, $amount);
    }

    public function label(): string
    {
        return $this->type === 'percent'
            ? $this->value.'%'.($this->max_discount ? ' (maks. '.rupiah($this->max_discount).')' : '')
            : rupiah($this->value);
    }
}
