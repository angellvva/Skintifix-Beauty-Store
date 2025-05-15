<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Alice Johnson',
                'email' => 'alicejohnson@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No.10, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '082134567891',
                'address' => 'Jl. Sudirman No.22, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Carla Dewi',
                'email' => 'carladewi@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '083234567892',
                'address' => 'Jl. Malioboro, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Daniel Smith',
                'email' => 'danielsmith@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '084234567893',
                'address' => 'Jl. Asia Afrika, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Emily Chen',
                'email' => 'emilychen@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '085234567894',
                'address' => 'Jl. Gajah Mada, Surabaya',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Farhan Prasetyo',
                'email' => 'farhanprasetyo@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '086234567895',
                'address' => 'Jl. Diponegoro, Medan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gina Tan',
                'email' => 'ginatan@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '087234567896',
                'address' => 'Jl. Ahmad Yani, Bali',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hendri Lesmana',
                'email' => 'hendrilesmana@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '088234567897',
                'address' => 'Jl. Bintaro Utama, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ivana Santoso',
                'email' => 'ivanasantoso@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '089234567898',
                'address' => 'Jl. Senopati, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Johan Lie',
                'email' => 'johanlie@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '081134567899',
                'address' => 'Jl. Kebon Jeruk, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
