<?php

namespace Database\Seeders;

use App\Models\ReceiptCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceiptCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            'consumer',
            'non consumer',
        ];

        foreach ($category as $item) {
            ReceiptCategory::create([
                'name' => $item
            ]);
        }
    }
}
