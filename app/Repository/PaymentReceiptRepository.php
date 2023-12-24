<?php

namespace App\Repository;

use App\Models\PaymentReceipt;
use App\Repository\interfaces\PaymentReceiptRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PaymentReceiptRepository implements PaymentReceiptRepositoryInterface
{
    public function all(): Collection
    {
        return PaymentReceipt::query()->with(['project', 'createdBy'])->get();
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return PaymentReceipt::query()->with(['project', 'createdBy'])->latest('id')->paginate($perPage);
    }

    public function findOrFail(int $id): PaymentReceipt
    {
        return PaymentReceipt::query()->with(['project', 'createdBy'])->findOrFail($id);
    }
}
