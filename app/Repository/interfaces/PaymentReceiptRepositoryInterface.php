<?php

namespace App\Repository\interfaces;

use App\Models\PaymentReceipt;
use Illuminate\Support\Collection;

interface PaymentReceiptRepositoryInterface
{
    public function all(): Collection;

    public function findOrFail(int $id): PaymentReceipt;
}
