<?php

namespace App\Repository\interfaces;

use App\Models\AcceptanceReceipt;
use Illuminate\Support\Collection;

interface AcceptanceReceiptRepositoryInterface
{
    public function all(): Collection;

    public function findOrFail(int $id): AcceptanceReceipt;
}
