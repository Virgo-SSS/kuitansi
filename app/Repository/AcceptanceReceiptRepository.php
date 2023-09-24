<?php

namespace App\Repository;

use App\Models\AcceptanceReceipt;
use App\Repository\interfaces\AcceptanceReceiptRepositoryInterface;
use Illuminate\Support\Collection;

class AcceptanceReceiptRepository implements AcceptanceReceiptRepositoryInterface
{
    public function all(): Collection
    {
        return AcceptanceReceipt::with(['project', 'createdBy', 'acceptanceReceiptPayment'])->get();
    }

    public function findOrFail(int $id): AcceptanceReceipt
    {
        return AcceptanceReceipt::with(['project', 'createdBy', 'acceptanceReceiptPayment'])->findOrFail($id);
    }
}
