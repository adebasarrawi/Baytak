<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Clear existing favorites
        DB::table('favorites')->truncate();

        // Check if users and properties exist
        if (DB::table('users')->count() == 0 || DB::table('properties')->count() == 0) {
            $this->command->error('Please seed users and properties first!');
            return;
        }

        $favorites = [];
        $users = DB::table('users')->pluck('id');
        $properties = DB::table('properties')->pluck('id');
        $now = Carbon::now();

        foreach ($users as $userId) {
            // Each user favorites 3-7 random properties
            $randomProperties = $properties->random(rand(3, 7));
            
            foreach ($randomProperties as $propertyId) {
                $favorites[] = [
                    'user_id' => $userId,
                    'property_id' => $propertyId,
                    'created_at' => $now->subDays(rand(0, 30)), // Random date in last 30 days
                    'updated_at' => $now
                ];
            }
        }

        DB::table('favorites')->insert($favorites);
        $this->command->info('Successfully seeded favorites!');
    }
}