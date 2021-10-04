<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Starship;
use Illuminate\Database\Eloquent\Factories\Factory;

class StarshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Starship::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'model' => $this->faker->word(2),
        ];
    }
}
