<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        ProductType::factory()->create(['name' => 'Уличные светильники']);
        ProductType::factory()->create(['name' => 'Промышленные светильники']);
        ProductType::factory()->create(['name' => 'Офисные светильники']);
        ProductType::factory()->create(['name' => 'Парковые опоры (светильники)']);
        ProductType::factory()->create(['name' => 'Кронштейны и закладные']);
        ProductType::factory()->create(['name' => 'Асуно, it-разработка ПО']);
        ProductType::factory()->create(['name' => 'Светофорные комплексы']);
        ProductType::factory()->create(['name' => 'Мобильное освещение']);
        ProductType::factory()->create(['name' => 'Архитектурная подсветка']);
        ProductType::factory()->create(['name' => 'Сопутствующие товары']);
    }
}
