<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptancePaymentForCategory extends Model
{
    use HasFactory;

    protected $table = 'acceptance_payment_for_categories';

    protected $fillable = [
        'name',
    ];
}
