<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];

    public const DEFAULTS = [
        'site_title' => 'Unggul Booking Hotel',
        'welcome_message' => 'Temukan hotel terbaik untuk liburan dan perjalanan bisnis Anda.',
        'primary_color' => '#4f46e5',
        'secondary_color' => '#f5b942',
        'meta_description' => 'Sistem pemesanan hotel online.',
        'meta_keywords' => 'hotel, booking, pemesanan hotel',
        'instagram' => '',
        'facebook' => '',
        'whatsapp' => '',
        'address' => 'Jakarta, Indonesia',
        'email' => 'info@unggulhotel.com',
        'phone' => '021-1234567',
        'footer_text' => '© Unggul Booking Hotel. All rights reserved.',
        'maintenance_mode' => '0',
        'default_language' => 'id',
        'timezone' => 'Asia/Jakarta',
        'logo' => 'images/logo.png',
    ];

    /** @return array<string, string|null> */
    public static function allValues(): array
    {
        try {
            return Cache::rememberForever('settings', function () {
                return array_merge(self::DEFAULTS, static::query()->pluck('value', 'key')->all());
            });
        } catch (\Throwable) {
            // mis. database belum dimigrasi
            return self::DEFAULTS;
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::allValues()[$key] ?? $default;
    }

    /** @param array<string, mixed> $values */
    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => is_bool($value) ? (int) $value : $value]);
        }
        Cache::forget('settings');
    }
}
