<?php

namespace App\Actions\Bank;

use App\Actions\Bank\Interfaces\DeleteBankActionInterface;
use App\Models\Bank;

class DeleteBank implements DeleteBankActionInterface
{
    public function handle(Bank $bank): void
    {
        $bank->delete();
    }
}
