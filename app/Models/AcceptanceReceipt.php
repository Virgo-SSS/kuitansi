<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AcceptanceReceipt extends Model
{
    use HasFactory;

    protected $table = 'acceptance_receipts';

    protected $fillable = [
        'customer_name',
        'amount',
        'project_id',
        'created_by',
        'category_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function acceptanceReceiptPayment(): HasOne
    {
        return $this->hasOne(AcceptanceReceiptPayment::class, 'acceptance_receipt_id');
    }
}
