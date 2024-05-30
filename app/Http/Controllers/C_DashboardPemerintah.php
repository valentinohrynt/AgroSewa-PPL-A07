<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Borrower;
use App\Models\EquipmentRequest;
use App\Models\EquipmentRequestLog;

class C_DashboardPemerintah extends Controller
{
    public function setDashboardPemerintah() // set dashboard pemerintah
    {
        $countofApply = EquipmentRequest::getDataEquipmentRequest()->count(); // menghitung semua equipment request yang sedang diproses
        $countofDoneApply = EquipmentRequestLog::getDataEquipmentRequestLog()->count(); // menghitung semua equipment request log (riwayat)
        $countofBorrowers = Borrower::getAllDataBorrower()->count(); // menghitung semua borrower
        $countofLenders = Lender::getAllDataLender()->count(); // menghitung semua lender

        return view('government.V_DashboardPemerintah', compact('countofApply', 'countofDoneApply', 'countofBorrowers', 'countofLenders')); // mengembalikan view bersama dengan data - data di atas
    }
    public function HalPengajuanBantuanPemerintah() // set halaman pengajuan bantuan pemerintah
    {
        return redirect('HalPengajuanBantuanPemerintah');
    }
    public function HalRiwayatPemerintah() // set halaman riwayat pemerintah
    {
        return redirect('HalRiwayatPemerintah');
    }
    public function HalProfilPemerintah() // set halaman profil pemerintah
    {
        return redirect('HalProfilPemerintah');
    }
    public function HalAkunKelompokTaniPemerintah() // set halaman akun kelompok tani pemerintah
    {
        return redirect('HalAkunKelompokTaniPemerintah');
    }
}
