<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        ProductType::factory()->create(['name' => 'Игрушки']);
        ProductType::factory()->create(['name' => 'Корма']);
        ProductType::factory()->create(['name' => 'Лекарства']);
        ProductType::factory()->create(['name' => 'Ошейники']);
        ProductType::factory()->create(['name' => 'Миски']);
        ProductType::factory()->create(['name' => 'Кормушки']);
        ProductType::factory()->create(['name' => 'Аквариумы']);
        ProductType::factory()->create(['name' => 'Клетки']);
        ProductType::factory()->create(['name' => 'Террариумы']);
        ProductType::factory()->create(['name' => 'Муравьиные фермы']);
    }
}
