<?php

namespace App\Models;

use App\Models\EquipmentRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentRequestLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_request_id',
    ];

    public static function getDataEquipmentRequestLogbyLenderId($id)
    {
        $DataEquipmentRequestLogbyLenderId = static::with('equipmentRequest')->whereHas('equipmentRequest', function ($query) use ($id) {
            $query->where('lender_id', $id);
        })->orderByDesc('created_at')->get();

        return $DataEquipmentRequestLogbyLenderId;
    }
    public static function getDataEquipmentRequestLog()
    {
        $DataEquipmentRequestLog = static::whereHas('equipmentRequest', function ($query) {
            $query->where('is_approved', 'accepted')->orWhere('is_approved', 'rejected');
        })->with('equipmentRequest')->orderByDesc('created_at')->get();
        return $DataEquipmentRequestLog;
    }

    public static function postDataEquipmentRequestLog($equipment_request_id)
    {
        return static::create([
            'equipment_request_id' => $equipment_request_id
        ]);
    }

    public function equipmentRequest()
    {
        return $this->belongsTo(EquipmentRequest::class, 'equipment_request_id');
    }
}
