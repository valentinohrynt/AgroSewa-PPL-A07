<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_HomepageKT extends Controller
{
    public function setHomepageKT(){
        return view("lenders.V_HomepageKT");
    }
    public function HalPenyewaanKT(){
        return redirect("HalPenyewaanKT");
    }
}
