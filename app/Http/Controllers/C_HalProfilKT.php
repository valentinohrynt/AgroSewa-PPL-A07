<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalProfilKT extends Controller
{
    public function setHalProfilKT()
    {
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        return view('lenders.V_HalProfilKT', compact('lender', 'user'));
    }
    public function FormEditProfilKT()
    {
        return redirect('HalProfilKT/FormEditProfilKT');
    }
}
