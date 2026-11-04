<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Hotel> */
class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => 'Hotel '.fake()->unique()->city(),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'price' => 500000,
            'rating' => 4.5,
            'image' => 'images/default-hotel.jpg',
            'gallery' => [],
            'facilities' => ['Free Wi-Fi'],
            'status' => 'active',
        ];
    }

    /** Hotel dengan tipe kamar bawaan (Standard x1, Deluxe x1.5, Suite x2). */
    public function withRooms(): static
    {
        return $this->afterCreating(fn (Hotel $hotel) => $hotel->roomTypes()->createMany(RoomType::DEFAULTS));
    }
}
