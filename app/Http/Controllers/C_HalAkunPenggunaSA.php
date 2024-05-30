<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Borrower;
use App\Models\Government;
use App\Http\Controllers\Controller;

class C_HalAkunPenggunaSA extends Controller
{
    public function setHalAkunPenggunaSA() // Fungsi ini berguna untuk menampilkan halaman HalAkunPenggunaSA
    {

        $countofGov = Government::getAllDataGovernment()->count(); // mengambil jumlah row semua data pemerintah
        $countofBorrowers = Borrower::getAllDataBorrower()->count(); // mengambil jumlah row semua data petani 
        $countofLenders = Lender::getAllDataLender()->count(); // mengambil semua row semua data kelompok tani

        return view('superadmin.V_HalAkunPenggunaSA', compact('countofGov', 'countofBorrowers', 'countofLenders')); // return ke halaman HalAkunPenggunaSA
    }
    public function HalAkunPenggunaSA_Pemerintah() // Fungsi ini berguna untuk menaruh redirect/berpindah ke Halaman Akun Pemerintah oleh superadmin
    {
        return redirect ('HalAkunPenggunaSA/AkunPemerintah'); // redirect ke halaman AkunPemerintah
    }
    public function HalAkunPenggunaSA_KT() // Fungsi ini berguna untuk menaruh redirect/berpindah ke Halaman Akun Kelompok Tani oleh superadmin
    {
        return redirect ('HalAkunPenggunaSA/AkunKT'); // redirect ke halaman AkunKT
    }
    public function HalAkunPenggunaSA_Petani() // Fungsi ini berguna untuk menaruh redirect/berpindah ke Halaman Akun Petani oleh superadmin
    {
        return redirect ('HalAkunPenggunaSA/AkunPetani'); // redirect ke halaman AkunPetani
    } 
}
