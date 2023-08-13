<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $method = [
            'tunai',
            'bank tunai',
            'bank cek',
            'bank bilyet giro',
        ];

        foreach ($method as $item) {
           PaymentMethod::create([
                'name' => $item
            ]);
        }
    }
}
