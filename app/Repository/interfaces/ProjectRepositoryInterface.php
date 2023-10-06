<?php

namespace App\Repository\interfaces;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;

    public function paginate(array $search = [], int $perPage = 30): LengthAwarePaginator;

    public function find(int $id): Project;
}
