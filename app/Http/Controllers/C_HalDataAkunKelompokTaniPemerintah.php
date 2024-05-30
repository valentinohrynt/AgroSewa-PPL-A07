<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunKelompokTaniPemerintah extends Controller
{
    public function setHalDataAkunKelompokTaniPemerintah(Request $request, $lender_id) // fungsi untuk set halaman data akun kelompok tani pemerintah
    {
        $lenderId = Crypt::decrypt($lender_id); // decrypt id lender 
        $lender = Lender::getDataLenderbyId($lenderId); // mengambil data lender berdasarkan id
        $userId = $lender->user_id; // mengambil id user
        $user = User::getDataUserbyId($userId); // mengambil data user berdasarkan id
        return view('government.V_HalDataAkunKelompokTaniPemerintah', compact('lender', 'user')); // mengembalikan view V_HalDataAkunKelompokTaniPemerintah beserta data lender dan user
    }
}
