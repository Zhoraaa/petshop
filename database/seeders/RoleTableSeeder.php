<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::factory()->create(['name' => 'Админ']);
        Role::factory()->create(['name' => 'Модер']);
        Role::factory()->create(['name' => 'Покупатель']);
    }
}
