<?php

namespace App\Repository;

use App\Models\Project;
use App\Repository\interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::remember('projects_all',60 * 60 * 24 * 30 , function () {
            return Project::all();
        });
    }

    public function paginate(array $search = [], int $perPage = 30): LengthAwarePaginator
    {
        return Project::query()
        ->when($search['name'] ?? null, fn (Builder $query, $name) => $query->where('name', $name))
        ->when($search['block'] ?? null, fn (Builder $query, $block) => $query->where('block', 'like', "%{$block}%"))
        ->when($search['type'] ?? null, fn (Builder $query, $type) => $query->where('type', 'like', "%{$type}%"))
        ->when($search['number'] ?? null, fn (Builder $query, $number) => $query->where('number', 'like', "%{$number}%"))
        ->paginate($perPage);
    }

    public function find(int $id): Project
    {
        return Project::findOrFail($id);
    }
}
