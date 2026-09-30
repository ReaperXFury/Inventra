<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eload extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'customer_name',
        'phone_number',
        'amount',
        'fee',
        'reference_number',
        'status',
        'notes',
    ];
}