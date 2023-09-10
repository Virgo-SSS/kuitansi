<?php

namespace App\Actions\Bank;

use App\Actions\Bank\Interfaces\CreateBankActionInterface;
use App\Models\Bank;

class CreateBank implements CreateBankActionInterface
{
    public function handle(array $data): void
    {
        Bank::create([
            'name' => $data['name'],
        ]);
    }
}
