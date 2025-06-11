<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Hotels
            [
                'category_name' => 'Hotels',
                'services' => [
                    [
                        'name' => 'Grand Luxury Hotel',
                        'description' => '5-star hotel with premium amenities including swimming pool, spa, and restaurant',
                        'price' => 200.00,
                        'capacity' => 4,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'Business Hotel',
                        'description' => 'Perfect for business travelers with meeting rooms and high-speed internet',
                        'price' => 150.00,
                        'capacity' => 2,
                        'is_available' => true,
                    ],
                ]
            ],
            // Flights
            [
                'category_name' => 'Flights',
                'services' => [
                    [
                        'name' => 'Domestic Flight - Economy',
                        'description' => 'Economy class tickets for domestic flights',
                        'price' => 100.00,
                        'capacity' => 1,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'International Flight - Business',
                        'description' => 'Business class tickets for international flights',
                        'price' => 500.00,
                        'capacity' => 1,
                        'is_available' => true,
                    ],
                ]
            ],
            // Travel Packages
            [
                'category_name' => 'Travel Packages',
                'services' => [
                    [
                        'name' => 'Beach Vacation Package',
                        'description' => '5 days 4 nights beach vacation including hotel and flights',
                        'price' => 800.00,
                        'capacity' => 2,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'Mountain Adventure Package',
                        'description' => '3 days 2 nights mountain trekking adventure with accommodation',
                        'price' => 400.00,
                        'capacity' => 4,
                        'is_available' => true,
                    ],
                ]
            ],
            // Villa
            [
                'category_name' => 'Villa',
                'services' => [
                    [
                        'name' => 'Beachfront Villa',
                        'description' => 'Luxury villa with private beach access and pool',
                        'price' => 300.00,
                        'capacity' => 6,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'Mountain View Villa',
                        'description' => 'Cozy villa with stunning mountain views',
                        'price' => 250.00,
                        'capacity' => 4,
                        'is_available' => true,
                    ],
                ]
            ],
            // Bus Tickets
            [
                'category_name' => 'Bus Tickets',
                'services' => [
                    [
                        'name' => 'Executive Bus Ticket',
                        'description' => 'Comfortable executive bus with reclining seats',
                        'price' => 30.00,
                        'capacity' => 1,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'VIP Bus Ticket',
                        'description' => 'VIP bus service with extra legroom and amenities',
                        'price' => 50.00,
                        'capacity' => 1,
                        'is_available' => true,
                    ],
                ]
            ],
            // Car Rental
            [
                'category_name' => 'Car Rental',
                'services' => [
                    [
                        'name' => 'Economy Car Rental',
                        'description' => 'Fuel-efficient car perfect for city driving',
                        'price' => 40.00,
                        'capacity' => 4,
                        'is_available' => true,
                    ],
                    [
                        'name' => 'Luxury Car Rental',
                        'description' => 'Premium luxury car for special occasions',
                        'price' => 100.00,
                        'capacity' => 4,
                        'is_available' => true,
                    ],
                ]
            ],
        ];

        foreach ($services as $categoryServices) {
            $category = Category::where('name', $categoryServices['category_name'])->first();
            
            if ($category) {
                foreach ($categoryServices['services'] as $service) {
                    $service['category_id'] = $category->id;
                    Service::create($service);
                }
            }
        }

        // Create additional random services using factory
        Service::factory(10)->create();
    }
} 