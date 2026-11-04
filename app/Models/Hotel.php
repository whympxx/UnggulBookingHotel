<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'name', 'slug', 'location', 'description', 'price',
        'rating', 'phone', 'image', 'gallery', 'facilities', 'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'rating' => 'float',
            'gallery' => 'array',
            'facilities' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Hotel $hotel) {
            if (blank($hotel->slug) || $hotel->isDirty('name')) {
                $hotel->slug = static::uniqueSlug($hotel->name, $hotel->id);
            }
        });
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'hotel';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function roomTypes(): HasMany
    {
        return $this->hasMany(RoomType::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /** Rating = rata-rata ulasan (jika sudah ada ulasan). */
    public function syncRatingFromReviews(): void
    {
        $avg = $this->reviews()->avg('rating');
        if ($avg !== null) {
            $this->forceFill(['rating' => round((float) $avg, 1)])->saveQuietly();
        }
    }

    /**
     * Filter halaman jelajah: harga, rating minimum dan urutan.
     *
     * @param array<string, mixed> $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->search($filters['search'] ?? null, $filters['location'] ?? null)
            ->when(filled($filters['min_price'] ?? null), fn ($q) => $q->where('price', '>=', (int) $filters['min_price']))
            ->when(filled($filters['max_price'] ?? null), fn ($q) => $q->where('price', '<=', (int) $filters['max_price']))
            ->when(filled($filters['min_rating'] ?? null), fn ($q) => $q->where('rating', '>=', (float) $filters['min_rating']));

        return match ($filters['sort'] ?? 'rating') {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('rating')->orderBy('name'),
        };
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /** Pencarian berdasarkan nama/lokasi dan filter lokasi. */
    public function scopeSearch(Builder $query, ?string $term, ?string $location = null): Builder
    {
        return $query
            ->when(filled($term), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$term.'%')
                ->orWhere('location', 'like', '%'.$term.'%')))
            ->when(filled($location) && $location !== 'all', fn ($q) => $q->where('location', 'like', '%'.$location.'%'));
    }

    public function imageUrl(): string
    {
        return $this->image ? asset($this->image) : asset('images/default-hotel.jpg');
    }

    /** @return list<string> */
    public function galleryUrls(): array
    {
        return array_map(fn ($p) => asset($p), $this->gallery ?: []);
    }

    public function formattedPrice(): string
    {
        return rupiah($this->price);
    }

    public function totalRooms(): int
    {
        return (int) $this->roomTypes->sum('total_rooms');
    }

    /** Data ringkas untuk dipakai JavaScript di halaman publik. */
    public function toCardArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'location' => $this->location,
            'price' => $this->price,
            'price_label' => $this->formattedPrice().'/Night',
            'rating' => $this->rating,
            'description' => $this->description,
            'image' => $this->imageUrl(),
            'gallery' => $this->galleryUrls(),
            'facilities' => $this->facilities ?: [],
            'agent' => $this->agent?->name,
            'agent_avatar' => $this->agent?->avatarUrl(),
            'url' => route('hotels.show', $this),
            'reviews_count' => $this->reviews_count ?? null,
            'book_url' => route('bookings.create', $this),
            'cart_url' => route('cart.add', $this),
            'wishlist_url' => route('wishlist.toggle', $this),
        ];
    }
}
