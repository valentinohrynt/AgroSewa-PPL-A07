<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\EquipmentRequestLog;

class C_HalRiwayatPengajuanBantuanPemerintah extends Controller
{
    public function setHalRiwayatPengajuanBantuanPemerintah(Request $request){
        $lenderId = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lenderId);
        $equipmentRequestLogs = EquipmentRequestLog::getDataEquipmentRequestLogbyLenderId($lenderId);
        return view('government.V_HalRiwayatPengajuanBantuanPemerintah', compact('equipmentRequestLogs', 'lender'));
    }
}
