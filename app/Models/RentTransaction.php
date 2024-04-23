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

    public static function postDataRentTransaction($borrower_id, $product_id, $rentDate, $returnDate)
    {
        return static::create([
            'borrower_id' => $borrower_id,
            'product_id' => $product_id,
            'rent_date' => $rentDate,
            'return_date' => $returnDate
        ]);
    }

    public static function getDataRentTransactionbyId($id)
    {
        $DataRentTransactionbyId = static::findOrFail($id);
        return $DataRentTransactionbyId;
    }

    public static function patchStatusRentTransactiontoCancelled($id)
    {
        return static::where('id', $id)->update(['is_completed' => 'cancelled']);
    }

    public static function patchStatusRentTransactiontoYes($id)
    {
        return static::where('id', $id)->update(['is_completed' => 'yes']);
    }
    
    public static function patchStatusRentTransactiontoNo($id)
    {
        return static::where('id', $id)->update(['is_completed' => 'no']);
    }

    public static function getDataRentTransactionbyBorrower($borrower)
    {
        $DataRentTransactionbyBorrower = static::where('borrower_id', $borrower->id)->where('is_completed', 'no')->get();
        return $DataRentTransactionbyBorrower;
    }

    public static function getDataRentTransactionbyProductId($id)
    {
        $DataRentTransactionbyProduct = static::where('product_id', $id)->where('is_completed', 'no');
        return $DataRentTransactionbyProduct;
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($transaction) {
            $transaction->transaction_number = Uuid::uuid4()->toString();
        });
    }
}