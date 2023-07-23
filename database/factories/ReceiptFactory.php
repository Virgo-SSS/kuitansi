<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receipt>
 */
class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'received_from' => $this->faker->name,
            'amount' => $this->faker->randomNumber(2),
            'in_payment_for' => $this->faker->sentence,
            'payment_method' => $this->faker->randomElement(['cash', 'transfer', 'giro']),
            'created_by' => User::factory(),
        ];
    }
}
