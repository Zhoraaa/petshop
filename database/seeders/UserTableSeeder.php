<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Factories\UserFactory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'login' => 'Admin',
            'email' => 'admin@admin',
            'email_verified_at' => null,
            'password' => bcrypt('Admin1!'),
            'remember_token' => null,
            'balance' => 10000, 
            'role' => 1,
            'banned' => 0,
        ]);
        User::factory()->count(14)->create();
    }
}
