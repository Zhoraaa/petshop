<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        PostType::factory()->create(['name' => 'Черновик']);
        PostType::factory()->create(['name' => 'Госучреждениям']);
        PostType::factory()->create(['name' => 'Полезная информация']);
    }
}
