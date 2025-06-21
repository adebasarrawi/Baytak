<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,           
            AreasSeeder::class,         
            PropertyTypeSeeder::class,   
            FeatureSeeder::class,        
            PropertySeeder::class,      
            PropertyFeatureSeeder::class, 
            PropertyImageSeeder::class,   
            AppraisersSeeder::class,       
            NotificationSeeder::class, 
            FavoriteSeeder::class,       
            TestimonialSeeder::class,

        ]);
    }
}