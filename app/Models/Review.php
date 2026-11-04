<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['user_id', 'hotel_id', 'rating', 'comment'];

    protected function casts(): array
    {
        return ['rating' => 'integer'];
    }

    protected static function booted(): void
    {
        // Rating hotel mengikuti rata-rata ulasan
        $sync = fn (Review $review) => $review->hotel?->syncRatingFromReviews();
        static::saved($sync);
        static::deleted($sync);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
