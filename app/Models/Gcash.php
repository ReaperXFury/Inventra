<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gcash extends Model
{
    protected $fillable = [
        'type',             // 'cash_in' or 'cash_out'
        'customer_name',    // Name of sender or receiver
        'phone_number',     // GCash account number (11 digits)
        'amount',           // Principal transaction amount
        'fee',              // Service fee/charge
        'reference_number', // GCash Ref No. (for audit & verification)
        'status',           // 'pending', 'completed', 'failed'
        'notes',            // Optional remarks
    ];

    /**
     * Helper to compute total amount collected/received (amount + fee).
     */
    public function getTotalAttribute(): float
    {
        return (float) $this->amount + (float) $this->fee;
    }
}
