<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HalDataAlatKT extends Controller
{
    public function setHalDataAlatKT()
    {
        
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
        $products = Product::where('lender_id', $lender->id)->get();
    
        return view('lenders.HalDataAlatKT', ['products' => $products]);
    }
    
    public function DataAlat(){
        return view('lenders.HalDataAlatKT');
    }
}
