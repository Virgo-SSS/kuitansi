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
            'type' => $this->faker->randomElement(['47/48', '50/50', '60/40', '70/30', '80/20', '90/10', '100/0', '0/100', '100/100', '0/0', '20/11', '32/11']),
        ];
    }
}
