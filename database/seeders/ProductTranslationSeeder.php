<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy product vừa tạo (giả sử chỉ có 1 sản phẩm demo)
        $product = DB::table('products')->latest('id')->first();
        if (!$product) {
            $this->command->error('No product found! Run ProductSeeder first.');
            return;
        }

        DB::table('product_translations')->insert([
            [
                'product_id' => $product->id,
                'language_code' => 'vi',
                'name' => 'Điện thoại thông minh',
                'description' => 'Điện thoại thông minh cao cấp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $product->id,
                'language_code' => 'en',
                'name' => 'Smartphone',
                'description' => 'High-end smartphone',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
