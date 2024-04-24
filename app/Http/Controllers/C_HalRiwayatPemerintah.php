<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalRiwayatPemerintah extends Controller
{
    public function setHalRiwayatPemerintah()
    {
        $lenders = Lender::all();
        return view ('government.V_HalRiwayatPemerintah', ['lenders'=> $lenders]);
    }
}
