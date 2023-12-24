<?php

namespace App\Repository;

use App\Models\AcceptanceReceipt;
use App\Repository\interfaces\AcceptanceReceiptRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AcceptanceReceiptRepository implements AcceptanceReceiptRepositoryInterface
{
    public function all(): Collection
    {
        return AcceptanceReceipt::query()->with(['project', 'createdBy', 'acceptanceReceiptPayment'])->get();
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return AcceptanceReceipt::query()->with(['project', 'createdBy', 'acceptanceReceiptPayment'])->latest('id')->paginate($perPage);
    }

    public function findOrFail(int $id): AcceptanceReceipt
    {
        return AcceptanceReceipt::query()->with(['project', 'createdBy', 'acceptanceReceiptPayment'])->findOrFail($id);
    }
}
