<?php

namespace App\Actions\Receipt\Interfaces;

use App\Models\AcceptanceReceipt;

interface EditAcceptanceReceiptActionInterface
{
    public function handle(AcceptanceReceipt $receipt, array $request): void;
}
