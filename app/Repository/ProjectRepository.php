<?php

namespace App\Repository;

use App\Models\Project;
use App\Repository\interfaces\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::all();
    }

    public function paginate(int $perPage = 30): LengthAwarePaginator
    {
        return Project::paginate(30);
    }
}
