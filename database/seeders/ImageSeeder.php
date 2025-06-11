<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
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

        $variants = DB::table('product_variants')->where('product_id', $product->id)->get();

        DB::table('images')->insert([
            [
                'product_id' => $product->id,
                'variant_id' => null,
                'url' => 'images/products/main-image.jpg',
                'alt_text' => 'Main product image',
                'is_main' => true,
                'position' =>1,
'created_at' => now(),
'updated_at' => now(),
],
[
'product_id' => $product->id,
'variant_id' => $variants[0]->id ?? null,
'url' => 'images/products/sm-black-64.jpg',
'alt_text' => 'Black - 64GB',
'is_main' => false,
'position' => 2,
'created_at' => now(),
'updated_at' => now(),
],
]);
}
}
