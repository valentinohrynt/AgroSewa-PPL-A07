<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class C_DashboardSA extends Controller
{
    public function setDashboardSA() // set dashboard superadmin
    {
        $countofTRT = RentTransaction::getDataNewRentTransaction()->count(); // mendapatkan jumlah transaksi hari ini
        $countofTNU = User::getDataNewUser()->count(); // mendapatkan jumlah user baru (hari ini)
        $countofART = RentTransaction::getAllDataRentTransaction()->count(); // mendapatkan jumlah semua transaksi
        $countofAU = User::getAllDataUser()->count(); // mendapatkan jumlah semua user

        return view('superadmin.V_DashboardSA', compact('countofTRT', 'countofTNU', 'countofART', 'countofAU')); // return ke view dashboardSA dengan data - data di atasnya tadi
    }

    public function HalPenyewaanSA() // redirect/alihkan/pindah ke halaman penyewaan superadmin
    {
        return redirect('HalPenyewaanSA');
    }

    public function HalRiwayatSA() // redirect/alihkan/pindah ke halaman riwayat superadmin
    {
        return redirect('HalRiwayatSA');
    }
    public function HalProfilSA() // redirect/alihkan/pindah ke halaman profil superadmin 
    {
        return redirect('HalProfilSA');
    }
    public function HalAkunPenggunaSA() // redirect/alihkan/pindah ke halaman akun pengguna superadmin
    {
        return redirect('HalAkunPenggunaSA');
    }
}
