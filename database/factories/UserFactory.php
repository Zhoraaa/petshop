<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'login' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('Password1!'),
            'remember_token' => Str::random(10),
            'balance' => $this->faker->numberBetween(0, 5000), 
            'role' => 3,
            'banned' => 0,
        ];
    }
}
