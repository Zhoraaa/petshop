<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        PostType::factory()->create(['name' => 'Пост']);
        PostType::factory()->create(['name' => 'Репост']);
        PostType::factory()->create(['name' => 'Полезная информация']);
    }
}
