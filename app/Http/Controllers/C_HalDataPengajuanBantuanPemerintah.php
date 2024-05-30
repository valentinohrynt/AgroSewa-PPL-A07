<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\EquipmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;


class C_HalDataPengajuanBantuanPemerintah extends Controller
{
    public function setHalDataPengajuanBantuanPemerintah(Request $request, $lender_id) // fungsi ini berguna untuk menampilkan ke halaman data pengajuan bantuan pemerintah
    {
        $lenderId = Crypt::decrypt($lender_id); // decrypt id lender
        $lender = Lender::getDataLenderbyId($lenderId); // mengambil data lender berdasarkan id
        $equipmentRequest = EquipmentRequest::getDataEquipmentRequestbyLenderId($lenderId); // mengambil data equipment request berdasarkan id
        return view('government.V_HalDataPengajuanBantuanPemerintah', compact('lender', 'equipmentRequest')); // mengembalikan view V_HalDataPengajuanBantuanPemerintah beserta data lender dan data equipment request
    }

    public function SetujuiPengajuanBantuan(Request $request, $id) // fungsi ini berguna untuk menyetujui pengajuan bantuan
    {
        EquipmentRequest::patchStatustoAccepted($id); // memanggil fungsi patchStatustoAccepted dari model EquipmentRequest
        return redirect()->back()->with('success', 'Pengajuan bantuan berhasil disetujui!');
    }

    public function TolakPengajuanBantuan(Request $request, $id) // fungsi ini berguna untuk menolak pengajuan bantuan
    {
        EquipmentRequest::patchStatustoRejected($id); // memanggil fungsi patchStatustoRejected dari model EquipmentRequest
        return redirect()->back()->with('success', 'Pengajuan bantuan berhasil ditolak!'); // mengembalikan ke halaman data pengajuan bantuan
    }
}
