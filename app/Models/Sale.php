<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'subtotal',
        'total_amount',
        'payment_method',
        'amount_paid',
        'change_amount',
    ];

    /**
     * Relationship: A sale has many individual line items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}