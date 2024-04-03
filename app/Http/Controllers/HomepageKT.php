<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageKT extends Controller
{
    public function setHomepageKT(){
        return view("lenders.HomepageKT");
    }
    public function HalPenyewaanKT(){
        return redirect("HalPenyewaanKT");
    }
}
