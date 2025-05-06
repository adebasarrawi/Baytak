<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Ali Ahmad', 'email' => 'ali.ahmad@example.com', 'password' => bcrypt('password123'), 'phone' => '0791234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sara Hussein', 'email' => 'sara.hussein@example.com', 'password' => bcrypt('password123'), 'phone' => '0781234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Khaled Mohamed', 'email' => 'khaled.mohamed@example.com', 'password' => bcrypt('password123'), 'phone' => '0771234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lina Faris', 'email' => 'lina.faris@example.com', 'password' => bcrypt('password123'), 'phone' => '0761234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ahmed Al-Jabari', 'email' => 'ahmed.jabari@example.com', 'password' => bcrypt('password123'), 'phone' => '0751234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maha Ahmed', 'email' => 'maha.ahmed@example.com', 'password' => bcrypt('password123'), 'phone' => '0741234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mohammad Ali', 'email' => 'mohammad.ali@example.com', 'password' => bcrypt('password123'), 'phone' => '0731234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rami Ayman', 'email' => 'rami.ayman@example.com', 'password' => bcrypt('password123'), 'phone' => '0721234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reem Faisal', 'email' => 'reem.faisal@example.com', 'password' => bcrypt('password123'), 'phone' => '0711234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Omar Nasser', 'email' => 'omar.nasser@example.com', 'password' => bcrypt('password123'), 'phone' => '0701234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Yasmin Jaber', 'email' => 'yasmin.jaber@example.com', 'password' => bcrypt('password123'), 'phone' => '0691234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kareem Taha', 'email' => 'kareem.taha@example.com', 'password' => bcrypt('password123'), 'phone' => '0681234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zainab Mohammad', 'email' => 'zainab.mohammad@example.com', 'password' => bcrypt('password123'), 'phone' => '0671234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jad Ahmad', 'email' => 'jad.ahmad@example.com', 'password' => bcrypt('password123'), 'phone' => '0661234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Razan Abdullah', 'email' => 'razan.abdullah@example.com', 'password' => bcrypt('password123'), 'phone' => '0651234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ayman Hassan', 'email' => 'ayman.hassan@example.com', 'password' => bcrypt('password123'), 'phone' => '0641234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maya Ziad', 'email' => 'maya.ziad@example.com', 'password' => bcrypt('password123'), 'phone' => '0631234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nadia Khalil', 'email' => 'nadia.khalil@example.com', 'password' => bcrypt('password123'), 'phone' => '0621234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Salman Zaki', 'email' => 'salman.zaki@example.com', 'password' => bcrypt('password123'), 'phone' => '0611234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Basma Rashid', 'email' => 'basma.rashid@example.com', 'password' => bcrypt('password123'), 'phone' => '0601234567', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }





}
