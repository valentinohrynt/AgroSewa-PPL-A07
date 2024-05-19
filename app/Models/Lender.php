<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lender extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'phone',
        'street',
        'village_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

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
    public static function getDataLenderbyId($id)
    {
        $DataLenderbyId = static::findOrFail($id);
        return $DataLenderbyId;
    }

    public static function getDataLenderbyEquipmentRequestData()
    {
        $DataLenderbyEquipmentRequestData = static::whereHas('equipmentRequests', function ($query) {
            $query->where('is_approved', 'process');
        })->get();
        return $DataLenderbyEquipmentRequestData;
        
    }

    public static function putDataLender($id, $phone, $street, $village_id)
    {
        $lender = static::find($id);
        $lender->update([
            'phone' => $phone,
            'street' => $street,
            'village_id' => $village_id
        ]);
    }
    public static function postDataLender($name, $nik, $phone, $street, $village_id, $user_id)
    {
        $DataLender = static::create(
            [
                'name' => $name,
                'nik' => $nik,
                'phone' => $phone,
                'street' => $street,
                'village_id' => $village_id,
                'user_id' => $user_id
            ]
        );
        return $DataLender;
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
    public static function getAllDataLender()
    {
        $AllDataLender = static::all();
        return $AllDataLender;
    }
    use HasFactory;
}
