<?php

namespace App\Actions\Bank\Interfaces;

use App\Models\Bank;

interface DeleteBankActionInterface
{
    public function handle(Bank $bank): void;
}
