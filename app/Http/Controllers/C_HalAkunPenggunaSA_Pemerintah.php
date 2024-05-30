<?php

namespace App\Http\Controllers;

use App\Models\Government;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_Pemerintah extends Controller
{
    public function setHalAkunPenggunaSA_Pemerintah() // fungsi ini digunakan untuk set halaman hal akun pengguna pemerintah superadmin
    {
        $government = Government::getAllDataGovernment(); // mengambil semua data pemerintah
        return view('superadmin.V_HalAkunPenggunaSA_Pemerintah', ['government' => $government]); // return halaman V_HalAkunPenggunaSA_Pemerintah dan $government agar dapat digunakan pada view
    }
    public function HalDataAkunPenggunaSA_Pemerintah($government_id) // fungsi ini digunakan untuk redirect/pindah ke halaman data akun pengguna pemerintah
    {
        return redirect()->route('HalDataAkunPenggunaSA_Pemerintah', ['government_id' => $government_id]); // redirect ke halaman HalDataAkunPenggunaSA_Pemerintah
    }
    public function TambahAkunPemerintah() // fungsi ini digunakan untuk redirect ke halaman tambah akun pemerintah 
    {
        return redirect()->route('TambahAkunPemerintah'); // redirect ke halaman TambahAkunPemerintah
    }
}
