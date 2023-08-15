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
                'email' => 'admin@assiway.com',
                'password' => bcrypt('admin1234'),
                'isAdmin' => 1
            ],
        ]);
    }
}