<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use Illuminate\Support\Facades\Auth;

class C_HalProfilSA extends Controller
{
    public function setHalProfilSA()
    {
        $user = Auth::user();
        $userId = $user -> id;
        $superadmin = Superadmin::getDataSuperadminbyUserId($userId);
        return view('superadmin.V_HalProfilSA', compact('superadmin', 'user'));
    } 
    public function FormEditProfilSA(){
        return redirect('HalProfilSA/FormEditProfilSA');
    }
}
