<?php

namespace Database\Seeders;

use App\Models\Traffic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrafficSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Traffic::query()->insert([
            [
                'page' => 'home',
                'book_id' => null
            ],
            [
                'page' => 'profile',
                'book_id' => null
            ],
            [
                'page' => 'book',
                'book_id' => null
            ]
        ]);
    }
}
