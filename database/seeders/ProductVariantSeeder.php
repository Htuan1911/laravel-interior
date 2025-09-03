<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
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

        DB::table('product_variants')->insert([
            [
                'product_id' => $product->id,
                'sku' => 'SM-BLK-64',
                'variant_name' => 'Black - 64GB',
                'price' => 1100.00,
                'stock_quantity' => 50,
                'weight' => 0.2,
                'image' => 'images/products/sm-black-64.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $product->id,
                'sku' => 'SM-WHT-128',
                'variant_name' => 'White - 128GB',
                'price' => 1300.00,
                'stock_quantity' => 30,
                'weight' => 0.2,
                'image' => 'images/products/sm-white-128.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
