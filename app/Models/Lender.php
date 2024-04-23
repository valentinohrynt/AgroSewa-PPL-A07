<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lender extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'lender_id');
    }
    use HasFactory;
    public function borrowers()
    {
        return $this->hasMany(Borrower::class, 'lender_id');
    }
    public function equipmentRequests()
    {
        return $this->hasMany(EquipmentRequest::class);
    }
    public static function getDataLenderbyUserId($id)
    {
        $DataLenderbyUserId = static::where('user_id', $id)->first();
        return $DataLenderbyUserId;
    }
    use HasFactory;
}
