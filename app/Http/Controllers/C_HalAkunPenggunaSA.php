<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Borrower;
use App\Models\Government;
use App\Http\Controllers\Controller;

class C_HalAkunPenggunaSA extends Controller
{
    public function setHalAkunPenggunaSA()
    {

        $countofGov = Government::getAllDataGovernment()->count();
        $countofBorrowers = Borrower::getAllDataBorrower()->count();
        $countofLenders = Lender::getAllDataLender()->count();

        return view('superadmin.V_HalAkunPenggunaSA', compact('countofGov', 'countofBorrowers', 'countofLenders'));
    }
    public function HalAkunPenggunaSA_Pemerintah()
    {
        return redirect ('HalAkunPenggunaSA/AkunPemerintah');
    }
    public function HalAkunPenggunaSA_KT()
    {
        return redirect ('HalAkunPenggunaSA/AkunKT');
    }
    public function HalAkunPenggunaSA_Petani()
    {
        return redirect ('HalAkunPenggunaSA/AkunPetani');
    }
}
