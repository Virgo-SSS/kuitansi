<?php

namespace App\Repository;

use App\Models\PaymentReceipt;
use App\Repository\interfaces\PaymentReceiptRepositoryInterface;
use Illuminate\Support\Collection;

class PaymentReceiptRepository implements PaymentReceiptRepositoryInterface
{
    public function all(): Collection
    {
        return PaymentReceipt::with(['project', 'createdBy'])->get();
    }

    public function findOrFail(int $id): PaymentReceipt
    {
        return PaymentReceipt::with(['project', 'createdBy'])->findOrFail($id);
    }
}
