<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';

    protected $fillable = [
        'received_from',
        'amount',
        'in_payment_for',
        'payment_method',
        'created_by',
    ];

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function amount(): Attribute
    {
        return new Attribute(function ($value) {
           get: return number_format($value, 0, ',', '.');
        });
    }

    public function paymentMethod(): Attribute
    {
        return new Attribute(function ($value) {
            get: return $value !== null ? Str::upper($value) : 'N/A';
        });
    }
}
