<?php

namespace Database\Factories;

use App\Models\Basket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketFactory extends Factory
{
    protected $model = Basket::class;

    public function definition()
    {
        return [
            'product_id' => $this->faker->randomElement(Product::get())->id,
            'orderer_id' => $this->faker->randomElement(User::get())->id,
            'count' => $this->faker->randomElement([1,2,3,4]),
        ];
    }
}
