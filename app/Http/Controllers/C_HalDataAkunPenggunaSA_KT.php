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
    public function setHalDataAkunPenggunaSA_KT(Request $request, $lender_id)
    {
        $lenderId = Crypt::decrypt($lender_id);
        $lender = Lender::getDataLenderbyId($lenderId);
        $userId = $lender->user_id;
        $user = User::getDataUserbyId($userId);
        return view('superadmin.V_HalDataAkunPenggunaSA_KT', compact('lender', 'user'));
    }
}
