<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPenggunaSA_KT extends Controller
{
    public function setHalDataAkunPenggunaSA_KT(Request $request, $lender_id) // fungsi untuk set Halaman data akun penggguna kelompok tani oleh superadmin
    {
        $lenderId = Crypt::decrypt($lender_id); // decrypt id kelompok tani
        $lender = Lender::getDataLenderbyId($lenderId); // mengambil data kelompok tani berdasarkan id
        $userId = $lender->user_id; // mengambil id user dari data kelompok tani yang bersangkutan
        $user = User::getDataUserbyId($userId); // mengambil data user berdasarkan id
        return view('superadmin.V_HalDataAkunPenggunaSA_KT', compact('lender', 'user')); // mengembalikan view V_HalDataAkunPenggunaSA_KT beserta data kelompok tani dan user 
    }
}
