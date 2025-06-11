<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $services = Service::all();

        // Create some sample bookings with different statuses
        foreach ($users as $user) {
            // Create pending booking
            Booking::create([
                'user_id' => $user->id,
                'service_id' => $services->random()->id,
                'booking_date' => now()->addDays(rand(1, 30)),
                'number_of_people' => rand(1, 4),
                'total_price' => rand(100, 1000),
                'status' => 'pending',
                'notes' => 'Sample pending booking',
                'booking_code' => strtoupper(Str::random(8)),
            ]);

            // Create confirmed booking
            Booking::create([
                'user_id' => $user->id,
                'service_id' => $services->random()->id,
                'booking_date' => now()->addDays(rand(1, 30)),
                'number_of_people' => rand(1, 4),
                'total_price' => rand(100, 1000),
                'status' => 'confirmed',
                'notes' => 'Sample confirmed booking',
                'booking_code' => strtoupper(Str::random(8)),
                'confirmed_at' => now(),
            ]);

            // Create completed booking in the past
            Booking::create([
                'user_id' => $user->id,
                'service_id' => $services->random()->id,
                'booking_date' => now()->subDays(rand(1, 30)),
                'number_of_people' => rand(1, 4),
                'total_price' => rand(100, 1000),
                'status' => 'completed',
                'notes' => 'Sample completed booking',
                'booking_code' => strtoupper(Str::random(8)),
                'confirmed_at' => now()->subDays(rand(31, 60)),
            ]);
        }

        // Create additional random bookings using factory
        Booking::factory(20)->create();
    }
} 