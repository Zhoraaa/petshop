<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Basket;

class BasketTableSeeder extends Seeder
{
    public function run()
    {
        Basket::factory(30)->create();
    }
}