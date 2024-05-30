<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalAkunKelompokTaniPemerintah extends Controller
{
    public function setHalAkunKelompokTaniPemerintah() // fungsi ini set view halaman hal akun kelompok tani pemerintah
    {
        $lenders = Lender::getAllDataLender(); // mengambil semua data kelompok tani pemerintah
        return view('government.V_HalAkunKelompokTaniPemerintah', ['lenders' => $lenders]); // return halaman V_HalAkunKelompokTaniPemerintah dan $lenders agar dapat digunakan pada view
    }

    public function HalDataAkunKelompokTaniPemerintah($lender_id) // fungsi ini mengarahkan/redirect/pindah ke halaman hal data akun kelompok tani pemerintah
    {
        return redirect()->route('HalDataAkunKelompokTaniPemerintah', ['lender_id' => $lender_id]); // redirect ke halaman hal data akun kelompok tani pemerintah
    }

    public function TambahAkunKelompokTaniPemerintah() // fungsi ini mengarahkan/redirect/pindah ke halaman tambah akun kelompok tani pemerintah
    {
        return redirect()->route('TambahAkunKelompokTaniPemerintah'); // redirect ke halaman tambah akun kelompok tani pemerintah
    }

    public function EditAkunKelompokTaniPemerintah($lender_id) // fungsi ini mengarahkan/redirect/pindah ke halaman edit akun kelompok tani pemerintah
    {
        return redirect()->route('EditAkunKelompokTaniPemerintah', ['lender_id' => $lender_id]); // redirect ke halaman edit akun kelompok tani pemerintah
    }
}
