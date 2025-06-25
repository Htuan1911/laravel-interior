<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạo danh mục chính - Ví dụ 1
        $categoryId1 = DB::table('categories')->insertGetId([
            'parent_id' => null,
            'status' => 'active',
            'created_at' => now(),
        ]);

        // Thêm bản dịch tiếng Việt cho danh mục 1
        DB::table('category_translations')->insert([
            'category_id' => $categoryId1,
            'language_code' => 'vi',
            'name' => 'Điện tử',
            'description' => 'Danh mục các sản phẩm điện tử',
            'created_at' => now(),
        ]);

        // Thêm bản dịch tiếng Anh cho danh mục 1
        DB::table('category_translations')->insert([
            'category_id' => $categoryId1,
            'language_code' => 'en',
            'name' => 'Electronics',
            'description' => 'Category for electronic products',
            'created_at' => now(),
        ]);

        // Tạo danh mục con thuộc danh mục 1 - Ví dụ 2
        $categoryId2 = DB::table('categories')->insertGetId([
            'parent_id' => $categoryId1,
            'status' => 'active',
            'created_at' => now(),
        ]);

        // Thêm bản dịch tiếng Việt cho danh mục 2
        DB::table('category_translations')->insert([
            'category_id' => $categoryId2,
            'language_code' => 'vi',
            'name' => 'Điện thoại',
            'description' => 'Danh mục điện thoại di động',
            'created_at' => now(),
        ]);

        // Thêm bản dịch tiếng Anh cho danh mục 2
        DB::table('category_translations')->insert([
            'category_id' => $categoryId2,
            'language_code' => 'en',
            'name' => 'Mobile Phones',
            'description' => 'Category for mobile phones',
            'created_at' => now(),
        ]);
    }
}
