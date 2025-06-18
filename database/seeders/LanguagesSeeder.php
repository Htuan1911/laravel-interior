<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('languages')->insert([
            ['code' => 'vi', 'name' => 'Vietnamese', 'created_at' => now()],
            ['code' => 'en', 'name' => 'English', 'created_at' => now()],
        ]);
    }
}
