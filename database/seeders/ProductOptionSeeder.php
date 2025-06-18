<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = DB::table('products')->latest('id')->first();
        if (!$product) {
            $this->command->error('No product found! Run ProductSeeder first.');
            return;
        }

        // Ví dụ 2 option: Màu sắc và Bộ nhớ
        DB::table('product_options')->insert([
            [
                'product_id' => $product->id,
                'name' => 'Color',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $product->id,
                'name' => 'Storage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
