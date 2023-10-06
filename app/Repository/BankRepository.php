<?php

namespace App\Repository;

use App\Models\Bank;
use App\Repository\interfaces\BankRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BankRepository implements BankRepositoryInterface
{
    public function all(string $search = ''): LengthAwarePaginator
    {
        return Bank::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(20);
    }

    public function find(int $id): Bank
    {
        return Bank::findOrFail($id);
    }
}
