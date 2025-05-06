<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        $features = [
            // Basic Features
            [
                'name' => 'Air Conditioning',
                'name_en' => 'Air Conditioning',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Central Heating',
                'name_en' => 'Central Heating',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Furnished',
                'name_en' => 'Furnished',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Unfurnished',
                'name_en' => 'Unfurnished',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Parking',
                'name_en' => 'Parking',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Kitchen Features
            [
                'name' => 'Fully Equipped Kitchen',
                'name_en' => 'Fully Equipped Kitchen',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Modern Kitchen',
                'name_en' => 'Modern Kitchen',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Outdoor Features
            [
                'name' => 'Balcony',
                'name_en' => 'Balcony',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Garden',
                'name_en' => 'Garden',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Swimming Pool',
                'name_en' => 'Swimming Pool',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Roof Terrace',
                'name_en' => 'Roof Terrace',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Safety Features
            [
                'name' => 'Security System',
                'name_en' => 'Security System',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'CCTV',
                'name_en' => 'CCTV',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Fire Alarm',
                'name_en' => 'Fire Alarm',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Accessibility Features
            [
                'name' => 'Elevator',
                'name_en' => 'Elevator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Wheelchair Access',
                'name_en' => 'Wheelchair Access',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Utility Features
            [
                'name' => 'Solar Panels',
                'name_en' => 'Solar Panels',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Generator',
                'name_en' => 'Generator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Water Tank',
                'name_en' => 'Water Tank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Special Features
            [
                'name' => 'Smart Home System',
                'name_en' => 'Smart Home System',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Home Office',
                'name_en' => 'Home Office',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Gym',
                'name_en' => 'Gym',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Jacuzzi',
                'name_en' => 'Jacuzzi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];


        DB::table('features')->insert($features);
    }
}