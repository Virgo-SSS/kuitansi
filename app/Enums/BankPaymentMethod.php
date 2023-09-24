<?php

namespace App\Enums;

enum BankPaymentMethod: int
{
    case TRANSFER = 1;
    case CEK = 2;
    case GIRO = 3;
}
