<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function account(Request $request){
        $user = Auth::user();
        if($user && $user->role_id == 2){
            return view('government.akun-government');
        }
        elseif($user && $user->role_id == 3){
            return view('borrowers.akun-borrower');
        }
        elseif($user && $user->role_id == 4){
            return view('lenders.akun-poktan');
        }
    }
    public function rent(Request $request){
        $user = Auth::user();
        if($user && $user->role_id == 3){
            return view('borrowers.penyewaan');
        }
        elseif($user && $user->role_id == 4){
            return view('lenders.penyewaan-poktan');
        }
    }

    public function productslender(Request $request){
        return view('lenders.alat-poktan');
    }
    public function apply(Request $request){
        $user = Auth::user();
        if($user && $user->role_id == 1){
            return view('superadmin.pengajuan-superadmin');
        }
        elseif($user && $user->role_id == 2){
            return view('government.pengajuan-pemerintah');
        }
        elseif($user && $user->role_id == 4){
            return view('lenders.pengajuan-poktan');
        }
    }
    public function homepoktan(){
        return view("lenders.home-poktan");
    }
}
