<?php

namespace Database\Factories;

use App\Enums\AcceptancePaymentForCategory;
use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Models\AcceptanceReceipt;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcceptanceReceiptPayment>
 */
class AcceptanceReceiptPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'acceptance_receipt_id' => AcceptanceReceipt::factory()->create()->id,
        ];
    }

    public function consumer(): static
    {
        $data = [
            'payment_for' => $this->faker->randomElement(AcceptancePaymentForCategory::cases())->value,
        ];

        if($data['payment_for'] != AcceptancePaymentForCategory::BOOKING_FEE->value) {
            // random text
            $data['payment_for_description'] = Str::random(30);
        }

        return $this->state(function (array $attributes) use ($data) {
            return $data;
        });
    }

    public function non_consumer(): static
    {
        $data = [
            'payment_for' => Str::random(30),
        ];

        return $this->state(function (array $attributes) use ($data) {
            return $data;
        });
    }

    public function tunai(): static
    {
        $data = [
            'payment_method' => PaymentMethod::TUNAI->value,
        ];

        return $this->state(function (array $attributes) use ($data) {
            return $data;
        });
    }

    public function bank(): static
    {
        $data = [
            'payment_method' => PaymentMethod::BANK->value,
            'bank_id' => Bank::factory()->create()->id,
            'bank_method' => $this->faker->randomElement(BankPaymentMethod::cases())->value,
        ];

        if($data['bank_method'] != BankPaymentMethod::TRANSFER->value) {
            $data['cek_or_giro_number'] = $this->faker->numberBetween(1, 1000);
        }
        
        return $this->state(function (array $attributes) use ($data) {
            return $data;
        });
    }
}
