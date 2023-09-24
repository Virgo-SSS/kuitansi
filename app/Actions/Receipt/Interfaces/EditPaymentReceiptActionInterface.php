<?php

namespace App\Actions\Receipt\Interfaces;

use App\Models\PaymentReceipt;

interface EditPaymentReceiptActionInterface
{
    public function handle(PaymentReceipt $receipt, array $data): void;
}
