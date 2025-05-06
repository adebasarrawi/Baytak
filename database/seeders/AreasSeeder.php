<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreasSeeder extends Seeder
{
    public function run()
    {
        $areas = [
            // Amman Governorate
            [
                'name' => 'Abdoun',
                'name_en' => 'Abdoun',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sweifieh',
                'name_en' => 'Sweifieh',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Jabal Amman',
                'name_en' => 'Jabal Amman',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Shmeisani',
                'name_en' => 'Shmeisani',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Dabouq',
                'name_en' => 'Dabouq',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Tlaa Al-Ali',
                'name_en' => 'Tlaa Al-Ali',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Khalda',
                'name_en' => 'Khalda',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Marka',
                'name_en' => 'Marka',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Jubeiha',
                'name_en' => 'Jubeiha',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Taborbour',
                'name_en' => 'Taborbour',
                'governorate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Zarqa Governorate
            [
                'name' => 'Zarqa City Center',
                'name_en' => 'Zarqa City Center',
                'governorate_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'New Zarqa',
                'name_en' => 'New Zarqa',
                'governorate_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Hitteen',
                'name_en' => 'Hitteen',
                'governorate_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sahab',
                'name_en' => 'Sahab',
                'governorate_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Irbid Governorate
            [
                'name' => 'Irbid City Center',
                'name_en' => 'Irbid City Center',
                'governorate_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Ramtha',
                'name_en' => 'Ramtha',
                'governorate_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Huson',
                'name_en' => 'Huson',
                'governorate_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Aqaba Governorate
            [
                'name' => 'Aqaba City Center',
                'name_en' => 'Aqaba City Center',
                'governorate_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Tala Bay',
                'name_en' => 'Tala Bay',
                'governorate_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Ayla Oasis',
                'name_en' => 'Ayla Oasis',
                'governorate_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('areas')->insert($areas);
    }
}