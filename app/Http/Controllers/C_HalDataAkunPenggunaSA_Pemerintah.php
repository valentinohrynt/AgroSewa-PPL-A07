<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Government;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPenggunaSA_Pemerintah extends Controller
{
    public function setHalDataAkunPenggunaSA_Pemerintah(Request $request, $government_id) // fungsi ini berguna untuk menampilkan ke halaman data akun pemerintah
    {
        $governmentId = Crypt::decrypt($government_id); // fungsi ini berguna untuk mendekripsi id (decrypt government_id)
        $government = Government::getDataGovernmentbyId($governmentId); // mengambil data pemerintah berdasarkan id
        $userId = $government->user_id; // mengambil id user 
        $user = User::getDataUserbyId($userId); // mengambil data user berdasarkan id
        return view('superadmin.V_HalDataAkunPenggunaSA_Pemerintah', compact('government', 'user')); // menampilkan ke halaman data akun pemerintah dengan data government dan user
    }
}
