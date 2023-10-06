<?php

namespace App\Repository;

use App\Models\Bank;
use App\Repository\interfaces\BankRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BankRepository implements BankRepositoryInterface
{
    public function all(string $search = ''): Collection
    {
        return Bank::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->get();
    }

    public function paginate(int $perPage = 30, string $search = ''): LengthAwarePaginator
    {
        return Bank::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);
    }

    public function find(int $id): Bank
    {
        return Bank::findOrFail($id);
    }
}
