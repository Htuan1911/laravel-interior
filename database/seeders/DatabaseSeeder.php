<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call([
        //     LanguagesSeeder::class,
        //     CategorySeeder::class,
        //     CategoryTranslationSeeder::class,
        // ]);
        $this->call([
    ProductSeeder::class,
    ProductTranslationSeeder::class,
    ProductOptionSeeder::class,
    ProductOptionValueSeeder::class,
    ProductVariantSeeder::class,
    VariantOptionValueSeeder::class,
    ImageSeeder::class,
        ]);
        
    }

}
