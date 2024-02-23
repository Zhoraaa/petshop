<?php


namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'more_inf' => $this->faker->paragraph,
            'cost' => round($this->faker->numberBetween(100, 2000), -2),
            'type' => $this->faker->randomElement(ProductType::get())->id,
        ];
    }
}
