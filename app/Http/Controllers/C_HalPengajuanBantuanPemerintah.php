<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalPengajuanBantuanPemerintah extends Controller
{
    public function setHalPengajuanBantuanPemerintah()
    {
        $lenders = Lender::getDataLenderbyEquipmentRequestData();
        return view('government.V_HalPengajuanBantuanPemerintah', ['lenders' => $lenders]);
    }

    public function HalDataPengajuanBantuanPemerintah(Request $request, $lender_id)
    {
        return redirect()->route('HalDataPengajuanBantuanPemerintah', ['lender_id' => $lender_id]);
    }
}
