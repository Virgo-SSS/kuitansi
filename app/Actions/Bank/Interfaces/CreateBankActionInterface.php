<?php

namespace App\Actions\Bank\Interfaces;

interface CreateBankActionInterface
{
    public function handle(array $data): void;
}
