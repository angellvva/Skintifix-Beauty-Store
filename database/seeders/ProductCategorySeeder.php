<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('product_categories')->insert([
            [
                'name' => 'Moisturizer',  
                'description' => 'Hydrates and locks in moisture to keep the skin soft and supple.', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Serum & Essence', 
                'description' => 'Concentrated treatments that target specific skin concerns like dullness, acne, or aging.', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Sunscreen', 
                'description' => 'Protects the skin from harmful UV rays to prevent sunburn and premature aging.', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Makeup', 
                'description' => 'Cosmetic products used to enhance or alter the appearance of the face. ', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Cleanser', 
                'description' => 'Removes dirt, oil, and impurities from the skin to maintain clarity and health.', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Toner', 
                'description' => 'Balances the skin’s pH and prepares it to absorb serums and moisturizers effectively. ', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Mask', 
                'description' => 'Intensive skincare treatments designed to nourish, hydrate, or detoxify the skin. ', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Eye Care', 
                'description' => 'Specialized products that address puffiness, dark circles, and fine lines around the eyes.', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
        ]);
        
    }
}
