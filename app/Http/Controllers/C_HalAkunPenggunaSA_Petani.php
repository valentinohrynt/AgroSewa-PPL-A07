<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_Petani extends Controller
{
    public function setHalAkunPenggunaSA_Petani() // fungsi ini berguna untuk menampilkan halaman akun pengguna petani oleh superadmin
    {
        $borrowers = Borrower::getAllDataBorrower(); // mengambil semua data petani
        return view ('superadmin.V_HalAkunPenggunaSA_Petani', ['borrowers'=> $borrowers]); // return halaman V_HalAkunPenggunaSA_Petani dan $borrowers agar dapat digunakan pada view
    }
    public function HalDataAkunPenggunaSA_Petani($borrower_id) // fungsi ini berguna untuk menampilkan halaman data akun pengguna petani oleh superadmin
    {
        return redirect()->route('HalDataAkunPenggunaSA_Petani', ['borrower_id' => $borrower_id]); // redirect ke halaman HalDataAkunPenggunaSA_Petani
    }
}
