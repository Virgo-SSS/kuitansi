<?php

namespace Database\Seeders;

use App\Models\AcceptancePaymentForCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcceptancePaymentForCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'booking fee',
            'angsuran ke',
            'lain nya'
        ];

        foreach ($categories as $category) {
            AcceptancePaymentForCategory::create([
                'name' => $category
            ]);
        }
    }
}
