<?php

namespace Database\Factories;

use App\Enums\ReceiptCategory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentReceipt>
 */
class PaymentReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name,
            'amount' => $this->faker->numberBetween(1,200000000),
            'payment_for' => Str::random(30),
            'project_id' => Project::factory()->create()->id,
            'created_by' => User::factory()->create()->id,
            'category_id' => $this->faker->randomElement(ReceiptCategory::cases())->value,
        ];
    }
}
