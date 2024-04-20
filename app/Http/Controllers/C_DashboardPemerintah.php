<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\EquipmentRequest;
use App\Models\EquipmentRequestLog;
use App\Models\Lender;

class C_DashboardPemerintah extends Controller
{
    public function setDashboardPemerintah(){

        $countofApply = EquipmentRequest::where('is_approved', 'process')->count();
        $countofDoneApply = EquipmentRequestLog::where('is_approved', 'approved')->orWhere('is_approved', 'rejected')->count();
        $countofBorrowers = Borrower::all()->count();
        $countofLenders = Lender::all()->count();

        return view('government.V_DashboardPemerintah', compact('countofApply', 'countofDoneApply', 'countofBorrowers','countofLenders'));
    }
}
