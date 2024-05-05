<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'street',
        'village_id'
    ];
    public static function getDataSuperadminbyUserId($id)
    {
        $DataSuperadminbyUserId = static::where('user_id', $id)->first();
        return $DataSuperadminbyUserId;
    }
    public static function putDataSuperadmin($id, $name, $phone, $street, $village_id)
    {
        $superadmin = static::find($id);
        $superadmin->update([
            'name' => $name,
            'phone' => $phone,
            'street' => $street,
            'village_id' => $village_id
        ]);
    }
    public static function getDataSuperadminbyId($id)
    {
        $DataSuperadminbyId = static::where('id', $id)->first();
        return $DataSuperadminbyId;
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
