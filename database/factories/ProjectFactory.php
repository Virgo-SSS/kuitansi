<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'number' => $this->faker->numberBetween(1, 100),
            'block' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->randomElement(['house', 'shop', 'office']),
        ];
    }
}
