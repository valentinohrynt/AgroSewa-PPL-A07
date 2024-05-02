<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Borrower;
use App\Models\EquipmentRequest;
use App\Models\EquipmentRequestLog;

class C_DashboardPemerintah extends Controller
{
    public function setDashboardPemerintah(){

        $countofApply = EquipmentRequest::getDataEquipmentRequest()->count();
        $countofDoneApply = EquipmentRequestLog::getDataEquipmentRequestLog()->count();
        $countofBorrowers = Borrower::getAllDataBorrower()->count();
        $countofLenders = Lender::getAllDataLender()->count();

        return view('government.V_DashboardPemerintah', compact('countofApply', 'countofDoneApply', 'countofBorrowers','countofLenders'));
    }
    public function HalPengajuanBantuanPemerintah()
    {
        return redirect('HalPengajuanBantuanPemerintah');
    }
    public function HalRiwayatPemerintah()
    {
        return redirect('HalRiwayatPemerintah');
    }
}
