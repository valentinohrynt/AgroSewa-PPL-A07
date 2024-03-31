<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentLog extends Model
{
    protected $fillable = [
        'rent_transaction_id',
        'total_price',
        'actual_return_date',
    ];
}
