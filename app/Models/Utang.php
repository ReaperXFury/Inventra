<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utang extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'description',
        'due_date',
        'status',
    ];

}
