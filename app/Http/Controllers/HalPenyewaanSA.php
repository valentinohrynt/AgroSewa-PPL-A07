<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HalPenyewaanSA extends Controller
{
    public function setHalPenyewaanSA(){
        $lenders = Lender::all();
        return view('superadmin.HalPenyewaanSA',['lenders' => $lenders]);
    }
    // public function HalDataPenyewaanSA()
    // {
    //     return view('superadmin.HalDataPenyewaanSA');
    // }
}
