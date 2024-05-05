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
    public function setHalDataAkunPenggunaSA_Pemerintah(Request $request, $government_id)
    {
        $governmentId = Crypt::decrypt($government_id);
        $government = Government::getDataGovernmentbyId($governmentId);
        $userId = $government->user_id;
        $user = User::getDataUserbyId($userId);
        return view('superadmin.V_HalDataAkunPenggunaSA_Pemerintah', compact('government', 'user'));
    }
}
