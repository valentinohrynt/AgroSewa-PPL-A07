<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Borrower;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentTransaction extends Model
{
    protected $fillable = [
        'rent_date',
        'return_date',
    ];
    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $lastTransaction = RentTransaction::latest()->first();
            $prefix = 'T';
            $newNumber = $lastTransaction ? intval(substr($lastTransaction->transaction_number, 1)) + 1 : 1;
            $transaction->transaction_number = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        });
    }
}
