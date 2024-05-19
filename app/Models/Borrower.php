<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nik',
        'phone',
        'street',
        'land_area',
        'village_id',
        'lender_id',
        'user_id',
        'created_at',
        'updated_at'
    ];
    public static function getDataBorrowerbyId($id)
    {
        $DataBorrowerbyId = static::findOrFail($id);
        return $DataBorrowerbyId;
    }
    public static function putDataBorrower($id, $phone, $street, $village_id)
    {
        $borrower = static::find($id);
        $borrower->update([
            'phone' => $phone,
            'street' => $street,
            'village_id' => $village_id
        ]);
    }
    public static function getAllDataBorrower()
    {
        $AllDataBorrower = static::all();
        return $AllDataBorrower;
    }
    public static function getAllActiveDataBorrowerbyLenderId($lender_id)
    {
        $status = 'active';
        $AllActiveDataBorrowerbyLenderId = static::where('lender_id', $lender_id)
            ->whereHas('user', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();
        return $AllActiveDataBorrowerbyLenderId;
    }

    public static function getDataBorrowerbyUserId($id)
    {
        $DataBorrowerbyUser = static::where('user_id', $id)->first();
        return $DataBorrowerbyUser;
    }
    public function rentTransactions()
    {
        return $this->hasMany(RentTransaction::class, 'borrower_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lender()
    {
        return $this->belongsTo(Lender::class);
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function hasOngoingTransaction()
    {
        return RentTransaction::whereHas('borrower', function ($query) {
            $query->where('borrower_id', $this->id);
        })
            ->where('is_completed', 'no')
            ->exists();
    }
}
