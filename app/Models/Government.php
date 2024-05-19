<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    use HasFactory;
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
    protected $fillable = [
        'phone',
        'street',
        'village_id',
        'name',
        'user_id',
        'created_at',
        'updated_at'
    ];
    public static function getAllDataGovernment()
    {
        $DataGovernment = static::all();
        return $DataGovernment;
    }
    public static function getDataGovernmentbyUserId($id)
    {
        $DataGovernmentbyUserId = static::where('user_id', $id)->first();
        return $DataGovernmentbyUserId;
    }
    public static function putDataGovernment($id, $phone, $street, $village_id)
    {
        $government = static::find($id);
        $government->update([
            'phone' => $phone,
            'street' => $street,
            'village_id' => $village_id
        ]);
    }
    public static function postDataGovernment($name, $phone, $street, $village_id, $user_id)
    {
        $DataGovernment = static::create(
            [
                'name' => $name,
                'phone' => $phone,
                'street' => $street,
                'village_id' => $village_id,
                'user_id' => $user_id
            ]
        );
        return $DataGovernment;
    }
    public static function getDataGovernmentbyId($id)
    {
        $DataGovernmentbyId = static::where('id', $id)->first();
        return $DataGovernmentbyId;
    }
}
