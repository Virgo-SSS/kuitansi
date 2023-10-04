<?php

namespace App\Enums;

enum BankPaymentMethod: int
{
    case TRANSFER = 1;
    case CEK = 2;
    case GIRO = 3;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::TRANSFER->value => 'Transfer',
            self::CEK->value => 'Cek',
            self::GIRO->value => 'Giro',
        };
    }
}
