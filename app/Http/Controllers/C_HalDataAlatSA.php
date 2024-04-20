<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C_HalDataAlatSA extends Controller
{
    public function setHalDataAlatSA(Request $request){
        
        $lender_id = $request->input('lender_id');
        $lender = Lender::findOrFail($lender_id);
        $products = Product::with("lender")
        ->where('lender_id',$lender_id )->get();
        return view('superadmin.V_HalDataAlatSA', compact('products', 'lender'));
    }
}
