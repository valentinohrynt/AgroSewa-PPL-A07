<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\RentLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C_HalRiwayatPenyewaanSA extends Controller
{
    public function setHalRiwayatPenyewaanSA(Request $request)
    {
        $lenderId = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lenderId);
        $rentLogs = RentLog::getDataRentLogbyLenderId($lenderId);
        return view('superadmin.V_HalRiwayatPenyewaanSA', compact('rentLogs', 'lender'));
    }
}
