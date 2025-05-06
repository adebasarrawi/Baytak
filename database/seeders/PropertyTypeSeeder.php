<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertyTypeSeeder extends Seeder
{
    public function run()
    {
        $propertyTypes = [
            [
                'name' => 'Apartment',
                'name_en' => 'Apartment',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Villa',
                'name_en' => 'Villa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Land',
                'name_en' => 'Land',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Commercial Shop',
                'name_en' => 'Commercial Shop',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Warehouse',
                'name_en' => 'Warehouse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Duplex Apartment',
                'name_en' => 'Duplex Apartment',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Agricultural Land',
                'name_en' => 'Agricultural Land',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Residential Building',
                'name_en' => 'Residential Building',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Studio',
                'name_en' => 'Studio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Semi-Detached Villa',
                'name_en' => 'Semi-Detached Villa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Commercial Building',
                'name_en' => 'Commercial Building',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Chalet',
                'name_en' => 'Chalet',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Office',
                'name_en' => 'Office',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Penthouse',
                'name_en' => 'Penthouse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Factory',
                'name_en' => 'Factory',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('property_types')->insert($propertyTypes);

        $propertyFeatures = [];
        
        // Get all property IDs (1-20 based on your PropertySeeder)
        // Get all feature IDs (1-N based on your FeatureSeeder)
        
        // Example: Assign random features to each property
        foreach (range(1, 20) as $propertyId) {
            $featureIds = range(1, 10); // Adjust based on your actual features
            shuffle($featureIds);
            $selectedFeatures = array_slice($featureIds, 0, rand(3, 6));
            
            foreach ($selectedFeatures as $featureId) {
                $propertyFeatures[] = [
                    'property_id' => $propertyId,
                    'feature_id' => $featureId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
    

    }
}