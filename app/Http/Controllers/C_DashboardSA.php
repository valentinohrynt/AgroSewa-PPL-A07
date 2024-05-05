<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class C_DashboardSA extends Controller
{
    public function setDashboardSA()
    {

        $countofTRT = RentTransaction::getDataNewRentTransaction()->count();
        $countofTNU = User::getDataNewUser()->count();
        $countofART = RentTransaction::getAllDataRentTransaction()->count();
        $countofAU = User::getAllDataUser()->count();

        return view('superadmin.V_DashboardSA', compact('countofTRT', 'countofTNU', 'countofART', 'countofAU'));
    }

    public function HalPenyewaanSA()
    {
        return redirect('HalPenyewaanSA');
    }

    public function HalRiwayatSA()
    {
        return redirect('HalRiwayatSA');
    }
    public function HalProfilSA()
    {
        return redirect('HalProfilSA');
    }
    public function HalAkunPenggunaSA()
    {
        return redirect('HalAkunPenggunaSA');
    }
}
