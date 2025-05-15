<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('order_items')->insert([
            [
                'order_id' => 1, 
                'product_id' => 1, 
                'quantity' => 1, 
                'price' => 149000, 
                'created_at' => now()
            ],
            [
                'order_id' => 2, 
                'product_id' => 10, 
                'quantity' => 1, 
                'price' => 99000, 
                'created_at' => now()
            ],
            [
                'order_id' => 3, 
                'product_id' => 3, 
                'quantity' => 2, 
                'price' => 124800, 
                'created_at' => now()
            ],
            [
                'order_id' => 4, 
                'product_id' => 4, 
                'quantity' => 2, 
                'price' => 149000, 
                'created_at' => now()
            ],
            [
                'order_id' => 5, 
                'product_id' => 11, 
                'quantity' => 1, 
                'price' => 116000, 
                'created_at' => now()
            ],
            [
                'order_id' => 6, 
                'product_id' => 13, 
                'quantity' => 1, 
                'price' => 99000, 
                'created_at' => now()
            ],
            [
                'order_id' => 7, 
                'product_id' => 6, 
                'quantity' => 2, 
                'price' => 99000, 
                'created_at' => now()
            ],
            [
                'order_id' => 8, 
                'product_id' => 9, 
                'quantity' => 2, 
                'price' => 99000, 
                'created_at' => now()
            ],
            [
                'order_id' => 9, 
                'product_id' => 2, 
                'quantity' => 1, 
                'price' => 139000, 
                'created_at' => now()
            ],
            [
                'order_id' => 10, 
                'product_id' => 15, 
                'quantity' => 1, 
                'price' => 199000, 
                'created_at' => now()
            ],
        ]);
        
    }
}
