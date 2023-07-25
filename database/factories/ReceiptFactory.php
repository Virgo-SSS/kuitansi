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
        $payment_method = $this->faker->randomElement(['CASH', 'TRANSFER', 'GIRO']);
        $giro_bank = $payment_method == 'GIRO' ? $this->faker->randomElement(['BNI', 'BRI', 'BCA']) : null;

        return [
            'received_from' => $this->faker->name,
            'amount' => $this->faker->randomNumber(2),
            'in_payment_for' => $this->faker->sentence,
            'payment_method' => $payment_method,
            'giro_bank' => $giro_bank,
            'created_by' => User::factory(),
        ];
    }


}
