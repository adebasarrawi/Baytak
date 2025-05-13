<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,            // يجب أن يكون أولاً
            GovernorateSeeder::class,     // ثانياً
            AreasSeeder::class,           // ثالثاً
            PropertyTypeSeeder::class,    // رابعاً
            FeatureSeeder::class,         // خامساً
            PropertySeeder::class,        // سادساً (يعتمد على الأنواع والمحافظات والمناطق)
            PropertyFeatureSeeder::class, // سابعاً (يعتمد على العقارات والمميزات)
            PropertyImageSeeder::class,   // ثامناً (يعتمد على العقارات)
            AppraisersSeeder::class,      // تاسعاً (قد يعتمد على المستخدمين)
            NotificationSeeder::class,    // عاشراً (يعتمد على المستخدمين والعقارات)
            FavoriteSeeder::class,        // أخيراً (يعتمد على المستخدمين والعقارات)
        ]);
    }
}