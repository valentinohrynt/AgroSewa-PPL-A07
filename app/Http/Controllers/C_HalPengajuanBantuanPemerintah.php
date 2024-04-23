<?php

namespace App\Http\Controllers;

use App\Models\EquipmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;


class C_HalPengajuanBantuanPemerintah extends Controller
{
    public function setHalPengajuanBantuanPemerintah()
    {
        $equipmentRequest = EquipmentRequest::getDataEquipmentRequest();
        return view('government.V_HalPengajuanBantuanPemerintah', ['equipmentRequest' => $equipmentRequest]);
    }

    public function SetujuiPengajuanBantuan(Request $request, $id)
    {
        EquipmentRequest::patchStatustoAccepted($id);
        return redirect('HalPengajuanBantuanPemerintah')->with('success', 'Pengajuan bantuan berhasil disetujui!');
    }

    public function TolakPengajuanBantuan(Request $request, $id)
    {
        EquipmentRequest::patchStatustoRejected($id);
        return redirect('HalPengajuanBantuanPemerintah')->with('success', 'Pengajuan bantuan berhasil ditolak!');
    }
}
