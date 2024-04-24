<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\EquipmentRequestLog;
use App\Http\Controllers\Controller;

class C_HalRiwayatPengajuanBantuanSA extends Controller
{
    public function setHalRiwayatPengajuanBantuanSA(Request $request){
        $lenderId = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lenderId);
        $equipmentRequestLogs = EquipmentRequestLog::getDataEquipmentRequestLogbyLenderId($lenderId);
        return view('superadmin.V_HalRiwayatPengajuanBantuanSA', compact('equipmentRequestLogs', 'lender'));
    }
}
