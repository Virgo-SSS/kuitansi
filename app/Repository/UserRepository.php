<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
         return Cache::remember('users_all', 60 * 60 * 24 * 30, function () {
            return User::query()->get();
        });
    }

    public function paginate(array $search = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->when($search['uuid'] ?? null, fn (Builder $query, $uuid) => $query->where('uuid', 'like', "%{$uuid}%"))
            ->when($search['name'] ?? null, fn (Builder $query, $name) => $query->where('name', 'like', "%{$name}%"))
            ->when($search['role'] ?? null, fn (Builder $query, $role) => $query->whereHas('roles', fn (Builder $query) => $query->where('id', $role)))
            ->paginate($perPage);
    }

    public function find(int $id): User
    {
        return User::query()->findOrFail($id);
    }
}
