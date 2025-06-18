<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        // Admin (đã có)
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'), // Mật khẩu: password
            'phone' => '0123456789',
            'role_id' => 1, // Admin
            'status' => 'active',
        ]);

        // Users thường (role_id = 2)
        $users = [
            [
                'name' => 'Nguyen Van A',
                'email' => 'a@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0987654321',
                'role_id' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Tran Thi B',
                'email' => 'b@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0978123456',
                'role_id' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Le Van C',
                'email' => 'c@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0967123456',
                'role_id' => 2,
                'status' => 'inactive', // người dùng bị khóa chẳng hạn
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email'],
            ], $user);
        }
    }
}
