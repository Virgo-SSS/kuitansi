<?php

namespace App\Enums;

enum ReceiptType: int
{
    case PAYMENT = 1;
    case ACCEPTANCE = 2;
}
