<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_KT extends Controller
{
    public function setHalAkunPenggunaSA_KT() // fungsi untuk menampilkan ke halaman akun pengguna kelompok tani superadmin
    {
        $lenders = Lender::getAllDataLender(); // mengambil semua data kelompok tani
        return view('superadmin.V_HalAkunPenggunaSA_KT', ['lenders' => $lenders]); // mengembalikan view V_HalAkunPenggunaSA_KT dengan $lenders dalam bentuk array agar bisa dipanggil di view
    }
    public function HalDataAkunPenggunaSA_KT($lender_id) // fungsi untuk menampilkan ke halaman data akun pengguna kelompok tani superadmin
    {
        return redirect()->route('HalDataAkunPenggunaSA_KT', ['lender_id' => $lender_id]); // mengembalikan ke route HalDataAkunPenggunaSA_KT
    }
}
