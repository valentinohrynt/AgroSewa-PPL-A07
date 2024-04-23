<?php

namespace App\Models;

use App\Models\EquipmentRequestLog;
use Illuminate\Database\Eloquent\Model;

class EquipmentRequest extends Model
{
    protected $fillable = [
        'pdf_file_name',
        'equipment_request_number',
        'lender_id',
        'is_approved'
    ];

    public static function getDataEquipmentRequestbyLenderId($id)
    {
        $DataEquipmentRequestbyLenderId = static::where('lender_id', $id)->where('is_approved', 'process')->get();
        return $DataEquipmentRequestbyLenderId;
    }

    public static function getDataEquipmentRequest()
    {
        $DataEquipmentRequest = static::where('is_approved', 'process')->get();
        return $DataEquipmentRequest;
    }

    public static function postDataEquipmentRequest($pdf_file_name, $equipment_request_number, $lender_id)
    {
        $equipmentRequest = static::create([
            'pdf_file_name' => $pdf_file_name,
            'equipment_request_number' => $equipment_request_number,
            'lender_id' => $lender_id
        ]);

        $equipmentRequestId = $equipmentRequest -> id;

        return $equipmentRequestId;
    }

    public static function patchStatustoAccepted($id)
    {
        return static::where('id', $id)->update(['is_approved' => 'accepted']);
    }

    public static function patchStatustoRejected($id)
    {
        return static::where('id', $id)->update(['is_approved' => 'rejected']);
    }

    public function equipmentRequestLog()
    {
        return $this->hasOne(EquipmentRequestLog::class);
    }

    public function lender()
    {
        return $this->belongsTo(Lender::class, 'lender_id');
    }
}
