<?php

namespace App\Http\Controllers;

use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_HalProfilPemerintah extends Controller
{
    public function setHalProfilPemerintah()
    {
        $user = Auth::user();
        $userId = $user -> id;
        $government = Government::getDataGovernmentbyUserId($userId);
        return view('government.V_HalProfilPemerintah', compact('government', 'user'));
    } 
    public function FormEditProfilPemerintah(){
        return redirect('HalProfilPemerintah/FormEditProfilPemerintah');
    }
}
