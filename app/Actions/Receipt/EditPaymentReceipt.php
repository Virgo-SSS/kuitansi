<?php

namespace App\Actions\Receipt;

use App\Actions\Receipt\Interfaces\EditPaymentReceiptActionInterface;
use App\Models\PaymentReceipt;

class EditPaymentReceipt implements EditPaymentReceiptActionInterface
{
    public function handle(PaymentReceipt $receipt, array $data): void
    {
        $receipt->update($data);
    }
}
