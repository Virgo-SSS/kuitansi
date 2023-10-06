<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
         return User::all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }
}
