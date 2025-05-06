<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    public function run()
    {
        DB::table('governorates')->truncate(); 
        
        $governorates = [
            ['name' => 'Amman', 'name_en' => 'Amman', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Irbid', 'name_en' => 'Irbid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zarqa', 'name_en' => 'Zarqa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aqaba', 'name_en' => 'Aqaba', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mafraq', 'name_en' => 'Mafraq', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jerash', 'name_en' => 'Jerash', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Balqa', 'name_en' => 'Balqa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Karak', 'name_en' => 'Karak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tafilah', 'name_en' => 'Tafilah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Madaba', 'name_en' => 'Madaba', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($governorates as $gov) {
            DB::table('governorates')->insert([
                'name' => $gov['name'],
                'name_en' => $gov['name_en'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}







