<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    public function run(): void
    {
        Status::factory()->create(['name' => 'Ожидает оплаты']);
        Status::factory()->create(['name' => 'Оплачен']);
        Status::factory()->create(['name' => 'Получен']);
    }
}
