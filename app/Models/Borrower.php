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
        'village_id',
        'lender_id',
        'user_id'
    ];
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
