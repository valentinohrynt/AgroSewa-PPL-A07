<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunKelompokTaniPemerintah extends Controller
{
    public function setHalDataAkunKelompokTaniPemerintah(Request $request, $lender_id)
    {
        $lenderId = Crypt::decrypt($lender_id);
        $lender = Lender::getDataLenderbyId($lenderId);
        $userId = $lender->user_id;
        $user = User::getDataUserbyId($userId);
        return view('government.V_HalDataAkunKelompokTaniPemerintah', compact('lender', 'user'));
    }
}
