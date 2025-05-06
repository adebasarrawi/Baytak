<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GovernorateSeeder::class,
            PropertySeeder::class,
            AreasSeeder::class,
            PropertyTypeSeeder::class,
            PropertyFeatureSeeder::class,
            FeatureSeeder::class, // This seeds the features table
            PropertyImageSeeder::class,
            NotificationSeeder::class, // Should run after UserSeeder and PropertySeeder
            FavoriteSeeder::class, // Should run after UserSeeder and PropertySeeder

        ]);
    }
}
