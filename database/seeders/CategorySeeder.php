<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạo danh mục chính
        $categoryId = DB::table('categories')->insertGetId([
            'parent_id' => null,
            'status' => 'active',
            'created_at' => now(),
        ]);

        // Dịch tiếng Việt
        DB::table('category_translations')->insert([
            'category_id' => $categoryId,
            'language_code' => 'vi',
            'name' => 'Điện tử',
            'description' => 'Danh mục các sản phẩm điện tử',
            'created_at' => now(),
        ]);

        // Dịch tiếng Anh
        DB::table('category_translations')->insert([
            'category_id' => $categoryId,
            'language_code' => 'en',
            'name' => 'Electronics',
            'description' => 'Category for electronic products',
            'created_at' => now(),
        ]);

        
    }
}
