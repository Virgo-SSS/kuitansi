<?php

namespace  App\Enums;

enum ReceiptCategory: int
{
    case CONSUMER = 1;
    case NON_CONSUMER = 2;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::CONSUMER->value => 'Consumer',
            self::NON_CONSUMER->value => 'Non Consumer',
            default => 'Unknown',
        };
    }
}
