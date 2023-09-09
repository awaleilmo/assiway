<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                'name' => 'admin',
                'email' => 'admin@assiway.id',
                'password' => bcrypt('admin1234'),
                'isAdmin' => 1,
                'address' => fake()->address,
                'phone' => '085692699715',
                'gender' => 'L',
                'photo' => null,
                'date' => fake()->date,
                'place' => fake()->city,
                'typePhoto' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);
    }
}
