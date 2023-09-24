<?php

namespace App\Actions\Receipt;

use App\Actions\Receipt\Interfaces\CreatePaymentReceiptActionInterface;
use App\Models\PaymentReceipt;

class CreatePaymentReceipt implements CreatePaymentReceiptActionInterface
{
    public function handle(array $request): void
    {
        PaymentReceipt::create([
            'customer_name' => $request['customer_name'],
            'amount' => $request['amount'],
            'payment_for' => $request['payment_for'],
            'project_id' => $request['project_id'],
            'created_by' => auth()->id(),
            'category_id' => $request['category'],
        ]);
    }
}
