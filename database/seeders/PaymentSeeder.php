<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('payments')->insert([
            [
                'order_id' => 1, 
                'payment_date' => '2025-04-01', 
                'payment_method' => 'credit card', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 2, 
                'payment_date' => '2025-04-02', 
                'payment_method' => 'e-wallet', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 3, 
                'payment_date' => '2025-04-03', 
                'payment_method' => 'credit card', 
                'payment_status' => 'failed', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 4, 
                'payment_date' => '2025-04-04', 
                'payment_method' => 'e-wallet', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 5, 
                'payment_date' => '2025-04-05', 
                'payment_method' => 'credit card', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 6, 
                'payment_date' => '2025-04-06', 
                'payment_method' => 'e-wallet', 
                'payment_status' => 'failed', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 7, 
                'payment_date' => '2025-04-07', 
                'payment_method' => 'credit card', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 8, 
                'payment_date' => '2025-04-08', 
                'payment_method' => 'e-wallet', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 9, 
                'payment_date' => '2025-04-09', 
                'payment_method' => 'e-wallet', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'order_id' => 10, 
                'payment_date' => '2025-04-10', 
                'payment_method' => 'credit card', 
                'payment_status' => 'paid', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
        
    }
}
