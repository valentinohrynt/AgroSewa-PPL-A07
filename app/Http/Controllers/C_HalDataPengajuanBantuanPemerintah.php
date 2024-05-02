<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\EquipmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;


class C_HalDataPengajuanBantuanPemerintah extends Controller
{
    public function setHalDataPengajuanBantuanPemerintah(Request $request, $lender_id)
    {
        $lenderId = Crypt::decrypt($lender_id);
        $lender = Lender::getDataLenderbyId($lenderId);
        $equipmentRequest = EquipmentRequest::getDataEquipmentRequestbyLenderId($lenderId);
        return view('government.V_HalDataPengajuanBantuanPemerintah', compact('lender', 'equipmentRequest'));
    }

    public function SetujuiPengajuanBantuan(Request $request, $id)
    {
        EquipmentRequest::patchStatustoAccepted($id);
        return redirect()->back()->with('success', 'Pengajuan bantuan berhasil disetujui!');
    }

    public function TolakPengajuanBantuan(Request $request, $id)
    {
        EquipmentRequest::patchStatustoRejected($id);
        return redirect()->back()->with('success', 'Pengajuan bantuan berhasil ditolak!');
    }
}
