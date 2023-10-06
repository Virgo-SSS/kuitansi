<?php

namespace App\Repository\interfaces;

use App\Models\Bank;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BankRepositoryInterface
{
    public function all(string $search = ''): Collection;

    public function paginate(int $perPage = 30, string $search = ''): LengthAwarePaginator;

    public function find(int $id): Bank;
}
