<?php

namespace App\Actions\Receipt\Interfaces;

interface CreatePaymentReceiptActionInterface
{
    public function handle(array $request): void;
}
