<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleTableSeeder::class,
            PostTypeTableSeeder::class,
            ProductTypeTableSeeder::class,
            StatusTableSeeder::class
        ]);
    }
}