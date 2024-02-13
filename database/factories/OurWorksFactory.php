<?php


namespace Database\Factories;

use App\Models\OurWorks;
use Illuminate\Database\Eloquent\Factories\Factory;

class OurWorksFactory extends Factory
{
    protected $model = OurWorks::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'what_we_do' => $this->faker->paragraph,
            'cover' => 'default.png',
            'year' => $this->faker->year
        ];
    }
}
