<?php

namespace App\Repository;

use App\Models\Project;
use App\Repository\interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::all();
    }
}
