<?php

namespace App\Actions;

use App\Models\Receipt;

class CreateReceipt
{
    public function create(array $request): void
    {
        Receipt::create([
            'received_from' => $request['received_from'],
            'amount' => $request['amount'],
            'in_payment_for' => $request['in_payment_for'],
            'payment_method' => $request['payment_method'],
            'created_by' => auth()->user()->id,
        ]);
    }
}
