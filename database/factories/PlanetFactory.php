<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Planet;
use Illuminate\Database\Eloquent\Factories\Factory;
// use App\Models\Person;

class PlanetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Planet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            // 'person_id' => Person::factory(),
            'name' => $this->faker->word(),
            'terrain' => $this->faker->word(2),
        ];
    }
}
