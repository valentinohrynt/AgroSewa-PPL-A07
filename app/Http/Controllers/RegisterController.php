<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showDistrictsandVillages(){
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        $lenders = Lender::orderBy('name')->get();
    
        return view("register", compact("districts", "villages", "lenders"));
    }
}
