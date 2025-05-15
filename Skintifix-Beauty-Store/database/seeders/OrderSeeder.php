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
                'total_amount' =>149000, 
                'created_at' => now()
            ],
            [
                'user_id' => 2, 
                'order_date' => '2025-04-02', 
                'total_amount' => 99000, 
                'created_at' => now()
            ],
            [
                'user_id' => 3, 
                'order_date' => '2025-04-03', 
                'total_amount' => 249600, 
                'created_at' => now()
            ],
            [
                'user_id' => 4, 
                'order_date' => '2025-04-04', 
                'total_amount' => 298000, 
                'created_at' => now()
            ],
            [
                'user_id' => 5, 
                'order_date' => '2025-04-05', 
                'total_amount' => 116000, 
                'created_at' => now()
            ],
            [
                'user_id' => 6, 
                'order_date' => '2025-04-06', 
                'total_amount' => 99000, 
                'created_at' => now()
            ],
            [
                'user_id' => 7, 
                'order_date' => '2025-04-07', 
                'total_amount' => 198000, 
                'created_at' => now()
            ],
            [
                'user_id' => 8, 
                'order_date' => '2025-04-08', 
                'total_amount' => 198000, 
                'created_at' => now()
            ],
            [
                'user_id' => 9, 
                'order_date' => '2025-04-09', 
                'total_amount' => 139000, 
                'created_at' => now()
            ],
            [
                'user_id' => 10, 
                'order_date' => '2025-04-10', 
                'total_amount' => 199000, 
                'created_at' => now()
            ],
        ]);
        
    }
}
