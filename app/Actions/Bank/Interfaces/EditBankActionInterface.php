<?php

namespace App\Actions\Bank\Interfaces;

use App\Models\Bank;

interface EditBankActionInterface
{
    public function handle(Bank $bank, array $data): void;
}
