<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_HalBantuanKT extends Controller
{
    public function setHalBantuanKT()
    {
        return view("lenders.V_HalBantuanKT");
    }
}
