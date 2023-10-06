<?php

namespace App\Repository\interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 30): LengthAwarePaginator;
}
