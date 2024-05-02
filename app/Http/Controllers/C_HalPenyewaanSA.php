<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C_HalPenyewaanSA extends Controller
{
    public function setHalPenyewaanSA(){
        $lenders = Lender::getAllDataLender();
        return view('superadmin.V_HalPenyewaanSA',['lenders' => $lenders]);
    }
    public function HalDataPenyewaanSA()
    {
        return view('superadmin.V_HalDataPenyewaanSA');
    }
}
