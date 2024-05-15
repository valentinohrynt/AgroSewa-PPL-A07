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
        'is_approved',
        'product_category_id'
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

    public static function postDataEquipmentRequest($lender_id, $product_category_id)
    {
        $equipmentRequest = static::create([
            'lender_id' => $lender_id,
            'product_category_id' => $product_category_id
        ]);

        return $equipmentRequest;
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($equipmentRequest) {
            $latestRequest = static::latest()->first();
            $latestNumber = $latestRequest ? intval(substr($latestRequest->equipment_request_number, 2)) : 0;
            $newNumber = 'PB' . str_pad($latestNumber + 1, 4, '0', STR_PAD_LEFT);
            $equipmentRequest->equipment_request_number = $newNumber;
        });
    }
}
