<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentLog extends Model
{
    protected $fillable = [
        'rent_transaction_id',
        'total_price',
        'actual_return_date',
    ];

    public static function getDataRentLogbyBorrowerId($id)
    {
        $DataRentLogbyBorrowerId = static::with(['rentTransaction.product'])
            ->join('rent_transactions', 'rent_logs.rent_transaction_id', '=', 'rent_transactions.id')
            ->where(function ($query) use ($id) {
                $query->where('is_completed', 'yes')->orWhere('is_completed', 'cancelled')->where('borrower_id', $id);
            })
            ->orderByDesc('actual_return_date')
            ->get();
        return $DataRentLogbyBorrowerId;
    }
    public static function getDataRentLogbyLenderId($id)
    {
        $DataRentLogbyLenderId = static::with(['rentTransaction.product', 'rentTransaction.borrower'])
            ->whereHas('rentTransaction', function ($query) use ($id) {
                $query->where('is_completed', 'yes')->orWhere('is_completed', 'cancelled')
                    ->whereHas('product', function ($query) use ($id) {
                        $query->where('lender_id', $id);
                    });
            })
            ->orderByDesc('actual_return_date')
            ->get();
        return $DataRentLogbyLenderId;
    }
    public static function postDataRentLog($id, $totalPrice, $actualReturnDate)
    {
        RentLog::create([
            'rent_transaction_id' => $id,
            'total_price' => $totalPrice,
            'actual_return_date' => $actualReturnDate,
        ]);
    }
    public function rentTransaction()
    {
        return $this->belongsTo(RentTransaction::class, 'rent_transaction_id');
    }
}
