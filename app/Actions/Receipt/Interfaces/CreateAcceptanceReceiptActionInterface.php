<?php

namespace App\Actions\Receipt\Interfaces;

interface CreateAcceptanceReceiptActionInterface
{
    public function handle(array $request): void;
}
