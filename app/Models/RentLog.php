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
        $hasRentLog = RentLog::whereHas('rentTransaction', function ($query) use ($id) {
            $query->where('borrower_id', $id);
        })->exists();

        if (!$hasRentLog) {
            return collect();
        }

        $DataRentLogbyBorrowerId = static::with(['rentTransaction.product'])
            ->whereHas('rentTransaction', function ($query) use ($id) {
                $query->where('borrower_id', $id)
                    ->where(function ($query) {
                        $query->where('is_completed', 'yes')
                            ->orWhere('is_completed', 'cancelled');
                    });
            })
            ->orderByDesc('actual_return_date')
            ->get();

        return $DataRentLogbyBorrowerId;
    }

    public static function getDataRentLogbyLenderId($id)
    {
        $DataRentLogbyLenderId = static::with(['rentTransaction.product', 'rentTransaction.borrower'])
            ->whereHas('rentTransaction.product', function ($query) use ($id) {
                $query->where('lender_id', $id);
            })
            ->whereHas('rentTransaction', function ($query) {
                $query->where('is_completed', 'yes')->orWhere('is_completed', 'cancelled');
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
