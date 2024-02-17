<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            PostTableSeeder::class,
            ProductTableSeeder::class,
            BasketTableSeeder::class,
        ]);
    }
}