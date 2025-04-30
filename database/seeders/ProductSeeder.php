<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Sushi',
                'description' => 'Công thức:Chuẩn bị các nguyên liệu như cơm sushi, hải sản tươi...',
                'price' => 34,
                'stars' => 4,
                'img' => 'images/fe978d4b2a6e311efc53370bad41c302.jpg',
                'location' => 'Japan',
                'type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pizza Margherita',
                'description' => 'Công thức:Chuẩn bị bột làm bánh pizza...',
                'price' => 33,
                'stars' => 4,
                'img' => 'images/f38f470cc1972c270320c222c3aca9fb.jpg',
                'location' => 'Ý',
                'type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phở',
                'description' => 'Công thức:Nấu nước dùng từ xương gà hoặc xương bò...',
                'price' => 10,
                'stars' => 5,
                'img' => 'images/acaa4cdee4b8aa7bf33f2140ce36860c.jpg',
                'location' => 'Việt Nam',
                'type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paella',
                'description' => 'Công thức:Nấu nước dùng từ củ hành, tỏi, cà chua...',
                'price' => 5,
                'stars' => 4,
                'img' => 'images/34b0eaad01e8a95a02df1d934517591c.png',
                'location' => 'Tây Ban Nha',
                'type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Croissant',
                'description' => 'Công thức:Làm bột từ bột mì, men nở...',
                'price' => 8,
                'stars' => 4,
                'img' => 'images/0f61cb5dd19d38a11e5a9133333eca07.jpeg',
                'location' => 'Pháp',
                'type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    
}
