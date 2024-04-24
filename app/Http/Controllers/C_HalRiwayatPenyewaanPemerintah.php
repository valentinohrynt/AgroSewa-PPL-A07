<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use App\Models\RentLog;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class C_HalRiwayatPenyewaanPemerintah extends Controller
{
    public function setHalRiwayatPenyewaanPemerintah(Request $request)
    {
        $lenderId = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lenderId);
        $rentLogs = RentLog::getDataRentLogbyLenderId($lenderId);
        return view('government.V_HalRiwayatPenyewaanPemerintah', compact('rentLogs', 'lender'));
    }
}
