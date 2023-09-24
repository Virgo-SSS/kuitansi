<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case TUNAI = 1;
    case BANK = 2;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::TUNAI->value => 'Tunai',
            self::BANK->value => 'Bank',
            default => 'Unknown'
        };
    }
}
