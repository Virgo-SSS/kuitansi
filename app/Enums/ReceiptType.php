<?php

namespace App\Enums;

enum ReceiptType: int
{
    case PAYMENT = 1;
    case ACCEPTANCE = 2;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::PAYMENT->value => 'Pembayaran',
            self::ACCEPTANCE->value => 'Penerimaan',
        };
    }
}
