<?php

namespace App\Repository\interfaces;

use App\Models\AcceptanceReceipt;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface AcceptanceReceiptRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 20): LengthAwarePaginator;

    public function findOrFail(int $id): AcceptanceReceipt;
}
