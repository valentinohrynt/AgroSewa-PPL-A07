<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model
{
    use HasFactory;
    public static function getDataSuperadminbyUserId($id)
    {
        $DataSuperadminbyUserId = static::where('user_id', $id)->first();
        return $DataSuperadminbyUserId;
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
