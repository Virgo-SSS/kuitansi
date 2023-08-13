<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AcceptancePaymentForCategorySeeder::class,
            PaymentMethodSeeder::class,
            ReceiptCategorySeeder::class,
        ]);
    }
}
