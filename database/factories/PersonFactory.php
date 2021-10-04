<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Person, Planet};
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'planet_id' => Planet::factory(),
            'name' => $this->faker->name(),
            'height' => $this->faker->numerify('###'),
            'mass' => $this->faker->numerify('##'),
            'hair_color' => $this->faker->safeColorName(),
            'gender' => $this->faker->word(),
            'homeworld' => $this->faker->word(),
        ];
    }
}
