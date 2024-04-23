<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\RentLog;
use Illuminate\Support\Facades\Auth;

class C_HalRiwayatPenyewaanKT extends Controller
{
    public function setHalRiwayatPenyewaanKT(){
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
    
        $rentLogs = RentLog::getDataRentLogbyLenderId($lenderId);
    
        return view('lenders.V_HalRiwayatPenyewaanKT', ['rentLogs' => $rentLogs]);
    }

    public function RiwayatPengajuanBantuanKT()
    {
        return redirect('HalRiwayatPengajuanBantuanKT');
    }
}
