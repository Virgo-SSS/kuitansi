<?php

namespace App\Services;

use App\Models\AcceptanceReceipt;
use App\Models\PaymentReceipt;

class ReceiptService
{
    public function setReceiptCode(AcceptanceReceipt|PaymentReceipt $receipt): string
    {
        if($receipt instanceof AcceptanceReceipt) {
            $receiptCode = config('receipt.acceptance_receipt_code');
        }

        if($receipt instanceof PaymentReceipt) {
            $receiptCode = config('receipt.payment_receipt_code');
        }

        $romanService = app(RomanService::class);
        $id = sprintf("%03s", $receipt->id);
        $code = $id . '/' . $receiptCode . '/' . $romanService->integerToRoman($receipt->created_at->format('m')) . '/' . $receipt->created_at->format('Y');

        return $code;
    }
}
