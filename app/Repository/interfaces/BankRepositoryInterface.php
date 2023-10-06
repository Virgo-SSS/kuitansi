<?php

namespace App\Repository\interfaces;

use App\Models\Bank;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BankRepositoryInterface
{
    public function all(string $search = ''): Collection;

    public function paginate(string $search = '', int $perPage = 30): LengthAwarePaginator;

    public function find(int $id): Bank;
}
