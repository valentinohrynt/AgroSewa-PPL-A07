<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalRiwayatSA extends Controller
{
    public function setHalRiwayatSA()
    {
        $lenders = Lender::all();
        return view ('superadmin.V_HalRiwayatSA', ['lenders'=> $lenders]);
    }
}
