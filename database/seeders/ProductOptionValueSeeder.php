<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionValueSeeder extends Seeder
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

        $options = DB::table('product_options')->where('product_id', $product->id)->get();

        // Lấy option id cho Color và Storage
        $colorOption = $options->firstWhere('name', 'Color');
        $storageOption = $options->firstWhere('name', 'Storage');

        if (!$colorOption || !$storageOption) {
            $this->command->error('Product options missing! Run ProductOptionSeeder first.');
            return;
        }

        DB::table('product_option_values')->insert([
            // Color values
            [
                'product_option_id' => $colorOption->id,
                'value' => 'Black',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_option_id' => $colorOption->id,
                'value' => 'White',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Storage values
            [
                'product_option_id' => $storageOption->id,
                'value' => '64GB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_option_id' => $storageOption->id,
                'value' => '128GB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
