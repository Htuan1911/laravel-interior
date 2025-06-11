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
        $productId = DB::table('products')->insertGetId([
    'category_id' => 1, // giả sử danh mục id = 1 đã tồn tại
    'base_price' => 1000.00,
    'status' => 'active',
    'created_at' => now(),
    'updated_at' => now(),
]);
    }
}
