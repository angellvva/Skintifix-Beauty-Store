<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'order_date' => '2025-04-01',
                'recipient_name' => 'Alice Johnson',
                'recipient_phone' => '081234567890',
                'recipient_address' => 'Jl. Merdeka No.10, Jakarta',
                'total_amount' => 169000,
                'subtotal' => 149000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 2,
                'order_date' => '2025-04-02',
                'recipient_name' => 'Budi Santoso',
                'recipient_phone' => '082134567891',
                'recipient_address' => 'Jl. Sudirman No.22, Bandung',
                'total_amount' => 119000,
                'subtotal' => 99000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 3,
                'order_date' => '2025-04-03',
                'recipient_name' => 'Carla Dewi',
                'recipient_phone' => '083234567892',
                'recipient_address' => 'Jl. Malioboro, Yogyakarta',
                'total_amount' => 289600,
                'subtotal' => 249600,
                'shipping_price' => 40000,
                'created_at' => now()
            ],
            [
                'user_id' => 4,
                'order_date' => '2025-04-04',
                'recipient_name' => 'Daniel Smith',
                'recipient_phone' => '084234567893',
                'recipient_address' => 'Jl. Asia Afrika, Bandung',
                'total_amount' => 318000,
                'subtotal' => 298000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'order_date' => '2025-04-05',
                'recipient_name' => 'Emily Chen',
                'recipient_phone' => '085234567894',
                'recipient_address' => 'Jl. Gajah Mada, Surabaya',
                'total_amount' => 136000,
                'subtotal' => 116000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 6,
                'order_date' => '2025-04-06',
                'recipient_name' => 'Farhan Prasetyo',
                'recipient_phone' => '086234567895',
                'recipient_address' => 'Jl. Diponegoro, Medan',
                'total_amount' => 119000,
                'subtotal' => 99000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 7,
                'order_date' => '2025-04-07',
                'recipient_name' => 'Gina Tan',
                'recipient_phone' => '087234567896',
                'recipient_address' => 'Jl. Ahmad Yani, Bali',
                'total_amount' => 238000,
                'subtotal' => 198000,
                'shipping_price' => 40000,
                'created_at' => now()
            ],
            [
                'user_id' => 8,
                'order_date' => '2025-04-08',
                'recipient_name' => 'Hendri Lesmana',
                'recipient_phone' => '088234567897',
                'recipient_address' => 'Jl. Bintaro Utama, Jakarta',
                'total_amount' => 238000,
                'subtotal' => 198000,
                'shipping_price' => 40000,
                'created_at' => now()
            ],
            [
                'user_id' => 9,
                'order_date' => '2025-04-09',
                'recipient_name' => 'Ivana Santoso',
                'recipient_phone' => '089234567898',
                'recipient_address' => 'Jl. Senopati, Jakarta',
                'total_amount' => 159000,
                'subtotal' => 139000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
            [
                'user_id' => 10,
                'order_date' => '2025-04-10',
                'recipient_name' => 'Johan Lie',
                'recipient_phone' => '081134567899',
                'recipient_address' => 'Jl. Kebon Jeruk, Jakarta',
                'total_amount' => 219000,
                'subtotal' => 199000,
                'shipping_price' => 20000,
                'created_at' => now()
            ],
        ]);
    }
}
