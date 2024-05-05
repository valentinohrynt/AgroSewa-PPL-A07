<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_KT extends Controller
{
    public function setHalAkunPenggunaSA_KT()
    {
        $lenders = Lender::getAllDataLender();
        return view('superadmin.V_HalAkunPenggunaSA_KT', ['lenders' => $lenders]);
    }
    public function HalDataAkunPenggunaSA_KT($lender_id)
    {
        return redirect()->route('HalDataAkunPenggunaSA_KT', ['lender_id' => $lender_id]);
    }
}
