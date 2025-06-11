<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hotels',
                'description' => 'Luxury and comfortable hotels for your stay'
            ],
            [
                'name' => 'Flights',
                'description' => 'Domestic and international flight tickets'
            ],
            [
                'name' => 'Travel Packages',
                'description' => 'Complete travel packages including accommodation and transportation'
            ],
            [
                'name' => 'Villa',
                'description' => 'Private villas for your perfect vacation'
            ],
            [
                'name' => 'Bus Tickets',
                'description' => 'Inter-city bus transportation tickets'
            ],
            [
                'name' => 'Car Rental',
                'description' => 'Rent a car for your convenience'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 