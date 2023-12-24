<?php

namespace App\Repository\interfaces;

use App\Models\PaymentReceipt;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PaymentReceiptRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 20): LengthAwarePaginator;

    public function findOrFail(int $id): PaymentReceipt;
}
