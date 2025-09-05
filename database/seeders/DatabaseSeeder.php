<?php

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
=======
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // Tạo 1 user test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
=======
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
    //     $this->call([
    // ProductSeeder::class,
    // ProductTranslationSeeder::class,
    // ProductOptionSeeder::class,
    // ProductOptionValueSeeder::class,
    // ProductVariantSeeder::class,
    // VariantOptionValueSeeder::class,
    // ImageSeeder::class,
   
    //     ]);
    $this->call([
        RoleSeeder::class,
        UserSeeder::class,
    ]);


    }

>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
}
