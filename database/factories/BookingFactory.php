<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $service = Service::inRandomOrder()->first();
        $numberOfPeople = fake()->numberBetween(1, 4);
        $status = fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']);
        $bookingDate = fake()->dateTimeBetween('-30 days', '+60 days');
        
        return [
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id,
            'service_id' => $service->id,
            'booking_date' => $bookingDate,
            'number_of_people' => $numberOfPeople,
            'total_price' => $service->price * $numberOfPeople,
            'status' => $status,
            'notes' => fake()->optional(0.7)->sentence(),
            'booking_code' => strtoupper(Str::random(8)),
            'confirmed_at' => in_array($status, ['confirmed', 'completed']) ? 
                fake()->dateTimeBetween('-30 days', $bookingDate) : null,
        ];
    }
} 