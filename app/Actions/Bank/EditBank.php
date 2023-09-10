<?php

namespace App\Actions\Bank;

use App\Actions\Bank\Interfaces\EditBankActionInterface;
use App\Models\Bank;

class EditBank implements EditBankActionInterface
{
    public function handle(Bank $bank, array $data): void
    {
        $bank->update($data);
    }
}
