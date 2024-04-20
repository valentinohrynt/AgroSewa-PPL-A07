<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalDataAlatKT extends Controller
{
    public function setHalDataAlatKT()
    {
        
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
        $products = Product::where('lender_id', $lender->id)->get();
    
        return view('lenders.V_HalDataAlatKT', ['products' => $products]);
    }
}
