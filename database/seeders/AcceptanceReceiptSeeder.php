<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Enums\ReceiptCategory;
use App\Models\AcceptanceReceiptPayment;
use Database\Factories\AcceptanceReceiptPaymentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcceptanceReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        while ($i <= 100) {
            $category = $this->pickRandomCategory();
            $paymentMethod = $this->pickRandomPaymentMethod();

            AcceptanceReceiptPayment::factory()
            ->count(1)
            ->$category()
            ->$paymentMethod()
            ->create();

            $i++;
        }
    }

    private function pickRandomCategory(): string
    {
        $category = ReceiptCategory::cases();
        $randomCategoryPick = rand(0, count($category) - 1);
        return strtolower($category[$randomCategoryPick]->name);
    }

    private function pickRandomPaymentMethod(): string
    {
        $paymentMethod = PaymentMethod::cases();
        $randomPaymentMethodPick = rand(0, count($paymentMethod) - 1);
        return strtolower($paymentMethod[$randomPaymentMethodPick]->name);
    }
}
