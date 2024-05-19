<?php

namespace App\Models;

use Carbon\Carbon;
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
        'utilization',
        'is_completed',
        'created_at',
        'updated_at'
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

    public static function getAllDataRentTransaction()
    {
        $AllDataRentTransaction = static::all();
        return $AllDataRentTransaction;
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

    public static function getDataNewRentTransaction()
    {
        $DataRentTransaction = static::where('is_completed', 'no')->whereDate('rent_date', now()->toDateString())->get();
        return $DataRentTransaction;
    }

    public static function getDataRentTransactionbyId($id)
    {
        $DataRentTransactionbyId = static::findOrFail($id);
        return $DataRentTransactionbyId;
    }

    public static function patchRentDateandReturnDate($id, $rent_date, $return_date)
    {
        $transaction = static::findOrFail($id);
        $transaction->update([
            'rent_date' => $rent_date,
            'return_date' => $return_date,
        ]);
        $DataRentDateandReturnDate = $transaction;
        return $DataRentDateandReturnDate;
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

    public static function getDataRentTransactionbyBorrowerId($id)
    {
        $DataRentTransactionbyBorrower = static::where('borrower_id', $id)->where('is_completed', 'no')->get();
        return $DataRentTransactionbyBorrower;
    }

    public static function getDataRentTransactionbyProductId($id)
    {
        $DataRentTransactionbyProduct = static::where('product_id', $id)->where('is_completed', 'no');
        return $DataRentTransactionbyProduct;
    }

    public static function getDataRentTransactionbyProductIds($ids)
    {
        $DataRentTransactionbyProductIds = static::with('product', 'borrower')->whereIn('product_id', $ids)->where('is_completed', 'no')->get();
        return $DataRentTransactionbyProductIds;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaction_number = Uuid::uuid4()->toString();
        });
    }
}
