<?php

namespace App\Enums;

enum AcceptancePaymentForCategory: string
{
    case BOOKING_FEE = 'Booking Fee';
    case ANGSURAN = 'Angsuran';
    case LAIN_NYA = 'Lain nya';
}
