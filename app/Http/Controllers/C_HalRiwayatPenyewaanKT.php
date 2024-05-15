<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lender;
use App\Models\RentLog;
use Illuminate\Support\Facades\Auth;

class C_HalRiwayatPenyewaanKT extends Controller
{
    public function setHalRiwayatPenyewaanKT()
    {
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
        $rentLogs = RentLog::getDataRentLogbyLenderId($lenderId);
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $income = RentLog::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');
        return view('lenders.V_HalRiwayatPenyewaanKT', compact('rentLogs', 'income'));
    }

    public function RiwayatPengajuanBantuanKT()
    {
        return redirect('HalRiwayatPenyewaanKT/HalRiwayatPengajuanBantuanKT');
    }
}
