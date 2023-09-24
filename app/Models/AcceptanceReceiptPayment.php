<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcceptanceReceiptPayment extends Model
{
    use HasFactory;

    protected $table = 'acceptance_receipt_payments';

    protected $fillable = [
        'acceptance_receipt_id',
        'payment_for',
        'payment_for_description',
        'payment_method',
        'bank_id',
        'bank_method',
        'cek_or_giro_number',
    ];

    public function acceptanceReceipt(): BelongsTo
    {
        return $this->belongsTo(AcceptanceReceipt::class, 'acceptance_receipt_id');
    }
}
