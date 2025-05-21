<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('products')->insert([
            [
                'name' => 'Sensitive Skin Hydration Moisturizer 40ml',
                'description' => 'Soothes redness in 5 minutes. Design for sensitive skin.',
                'image' => 'https://skintific.id/cdn/shop/files/1_8ba35f6c-6216-44df-b8ca-1c361b4ec24a.png?v=1745227769&width=700',
                'price' => 149000,
                'stock' => 150,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '5X Ceramide Barrier Moisturizer',
                'description' => 'Ceramide can help to repair skin barrier, moisturize the skin, calms disturbed skin cells, reduce redness, and soften the texture of the skin.',
                'image' => 'https://skintific.id/cdn/shop/files/s-05_226cc4d0-2a88-423f-aaa9-2106da190332.jpg?v=1745227848&width=700',
                'price' => 139000,
                'stock' => 180,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'AHA BHA PHA LHA Peeling Solution Serum',
                'description' => 'Peeling solution with 10% AHA, 1% BHA, 0.5% PHA and 0.5% LHA, the maximum concentration for effective result.',
                'image' => 'https://skintific.id/cdn/shop/files/FotoJet.jpg?v=1745227805&width=700',
                'price' => 124800,
                'stock' => 90,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Symwhite 377 Dark Spot Serum 20ml',
                'description' => 'Enriched SymWhite377 serum with lightweight texture and low molecular weight, easily penetrates the skin and effectively brightens the dark spots on the skin.',
                'image' => 'https://skintific.id/cdn/shop/files/s-17.jpg?v=1745227861&width=700',
                'price' => 149000,
                'stock' => 150,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'All Day Light Sunscreen Mist SPF50 PA++ 120ml',
                'description' => 'Sunscreen mist with 0.01nm fine spray, easy to carry and not ruin the makeup after apply. Invisible texture, not heavy and feels fresh.',
                'image' => 'https://skintific.id/cdn/shop/files/my-11134207-7r98z-lpkzymj0qn4q9d.jpg?v=1745227865&width=700',
                'price' => 99000,
                'stock' => 90,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Light Serum Sunscreen SPF50 PA++++',
                'description' => 'With SPF 50+ PA++++ to protect from UV A/UV B, blue light and anti pollution. Enriched with Vitamin C and Ferulic Acid as an antioxidant.',
                'image' => 'https://skintific.id/cdn/shop/files/S10.jpg?v=1745227798&width=700',
                'price' => 99000,
                'stock' => 110,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Perfect Stay Velvet Matte Cushion (00 PORCELAIN)',
                'description' => 'Cushion with a velvet matte finish, smooth matte and makes the final appearance flawless and looks like a healthy skin.',
                'image' => 'https://skintific.com/cdn/shop/files/134.jpg?v=1745227815&width=700',
                'price' => 169000,
                'stock' => 100,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Skintific All Day Perfect Serum Foundation 25ml (02 IVORY)',
                'description' => 'Foundation medium to full coverage with a soft matte finish, easy to build up and blendable naturally to the skin. Color Capsule Technology minimize the oxidation and keep the shade color stay all day without cracking or cakey.',
                'image' => 'https://skintific.id/cdn/shop/files/s-61_c3658a01-74e5-4a63-98cb-ad7bb5c0c598.jpg?v=1745227884&width=700',
                'price' => 199000,
                'stock' => 100,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '5X Ceramide Low pH Cleanser 80ml',
                'description' => 'Cleanser that effectively cleanse the face from dust and dirt gently without causing the skin to feel tight. It contains 5 different types of ceramides that nourish and maintain the skin barrier.',
                'image' => 'https://skintific.id/cdn/shop/files/s-01_ba42064c-ddd0-4702-86cf-6271620cbc6d.jpg?v=1745227846&width=700',
                'price' => 99000,
                'stock' => 70,
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Panthenol Gel Cleanser 120ml',
                'description' => 'This formula combines Panthenol and Amino Acid, cleaning deep into pores to help wash away skin impurities, excess oil and help prevent build up in pore.',
                'image' => 'https://skintific.id/cdn/shop/files/s-92_c8c73c5d-683a-4fe8-9284-d1b0f1efb6a4.jpg?v=1745227878&width=700',
                'price' => 99000,
                'stock' => 140,
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '5X Ceramide Soothing Toner',
                'description' => 'A daily-use toner designed to soothe the skin when the skin barrier is compromised and maintain skin moisture.',
                'image' => 'https://skintific.id/cdn/shop/files/SKT-12-5X_80ml.png?v=1745227813&width=700',
                'price' => 116000,
                'stock' => 200,
                'category_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '4D Hyaluronic Acid Barrier Essence Toner 100ml',
                'description' => 'Essence toner that provides moisturization with an easy to absorb texture. It contains ceramides and Centella Asiatica, which can maintain the skin barrier and soothe the skin.',
                'image' => 'https://skintific.id/cdn/shop/files/my-11134207-7qul0-ljw4mrtd03dm6f.jpg?v=1745227841&width=700',
                'price' => 116000,
                'stock' => 170,
                'category_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mugwort Mask Anti-Pores & Acne Clay Mask 55G',
                'description' => 'SKINTIFIC Mugwort Acne Clay Mask contains the best quality Mugwort extract to fight breakouts for brighter and brighter skin. Formulated with Mugwort, a popular ingredient in Korea for soothing acne.',
                'image' => 'https://skintific.id/cdn/shop/files/s-08_43e3c3ce-16b0-4722-9fea-c5d90cb95368.jpg?v=1745227839&width=700',
                'price' => 99000,
                'stock' => 130,
                'category_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Niacinamide Bright Boost Clay Stick',
                'description' => 'SKINTIFIC Niacinamide Bright Boost Clay Stick is a support brightening booster product that infused with Niacinamide, Pink Sea Salt, and Tranexamic Acid to brightens and evens skin tone.',
                'image' => 'https://skintific.id/cdn/shop/files/7_8bb8eb3c-8352-44be-ac19-1071d249250c.jpg?v=1745227808&width=700',
                'price' => 89000,
                'stock' => 150,
                'category_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '360 Crystal Massager Lifting Eye Cream',
                'description' => 'Also known as the Crystal Pen, it is used to tighten and brighten the skin around the eyes',
                'image' => 'https://images.soco.id/86d92edb-1de5-4260-a71c-93d030510f2f-.jpg',
                'price' => 199000,
                'stock' => 120,
                'category_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
