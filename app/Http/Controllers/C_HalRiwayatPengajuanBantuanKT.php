<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\EquipmentRequestLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalRiwayatPengajuanBantuanKT extends Controller
{
    public function setHalRiwayatPengajuanBantuanKT()
    {
        $user = Auth::user();
        $userId = $user -> id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender -> id;
        
        $equipmentRequestLogs = EquipmentRequestLog::getDataEquipmentRequestLogbyLenderId($lenderId);
        
        return view('lenders.V_HalRiwayatPengajuanBantuanKT', ['equipmentRequestLogs' => $equipmentRequestLogs]);        
    }
}
