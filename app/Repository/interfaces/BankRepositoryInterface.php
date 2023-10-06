<?php

namespace App\Repository\interfaces;

use App\Models\Bank;
use Illuminate\Pagination\LengthAwarePaginator;

interface BankRepositoryInterface
{
    public function all(string $search = ''): LengthAwarePaginator;

    public function find(int $id): Bank;
}
