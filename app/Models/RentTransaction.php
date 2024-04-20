<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Borrower;
use Illuminate\Database\Eloquent\Model;

class RentTransaction extends Model
{
    protected $fillable = [
        'borrower_id',
        'product_id',
        'transaction_number',
        'rent_date',
        'return_date',
        'is_completed'
    ];

    protected $table = 'rent_transactions';
    protected $dates = ['rent_date', 'return_date'];
    
    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function rentLog()
    {
        return $this->hasOne(RentLog::class);
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($transaction) {
            $transaction->transaction_number = Uuid::uuid4()->toString();
        });
    }
}
