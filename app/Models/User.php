<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_AGENT = 'agent';
    public const ROLE_ADMIN = 'admin';
    public const ROLES = [self::ROLE_USER, self::ROLE_AGENT, self::ROLE_ADMIN];

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'agency',
        'location', 'bio', 'avatar', 'social', 'language',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'social' => 'array',
        ];
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAgent(): bool
    {
        return $this->role === self::ROLE_AGENT;
    }

    /** Hotel yang dikelola agent ini. */
    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class, 'agent_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** Hotel favorit (wishlist). */
    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'wishlists')->withTimestamps();
    }

    public function avatarUrl(): string
    {
        return asset($this->avatar ?: 'images/profil.jpg');
    }

    /** Halaman tujuan setelah login sesuai role. */
    public function homeRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => route('admin.dashboard'),
            self::ROLE_AGENT => route('agent.dashboard'),
            default => route('home'),
        };
    }
}
