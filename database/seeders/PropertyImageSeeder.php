<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertyImageSeeder extends Seeder
{
    public function run()
    {
        // Make sure we have properties first
        if (DB::table('properties')->count() == 0) {
            $this->command->error('Please seed properties first!');
            return;
        }

        $propertyIds = DB::table('properties')->pluck('id');
        $images = [];

        foreach ($propertyIds as $propertyId) {
            // Each property gets 3-5 images
            $imageCount = rand(3, 5);
            
            for ($i = 0; $i < $imageCount; $i++) {
                $images[] = [
                    'property_id' => $propertyId,
                    'image_path' => $this->generateImagePath($propertyId, $i),
                    'is_primary' => $i === 0, // First image is primary
                    'sort_order' => $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }

        DB::table('property_images')->insert($images);
    }

    private function generateImagePath($propertyId, $index): string
    {
        // You can modify this to match your actual image storage structure
        $imageTypes = [
            'living-room',
            'bedroom',
            'kitchen',
            'bathroom',
            'exterior',
            'garden',
            'pool'
        ];
        
        $type = $imageTypes[array_rand($imageTypes)];
        return "properties/{$propertyId}/{$type}-" . ($index + 1) . ".jpg";
    }
}