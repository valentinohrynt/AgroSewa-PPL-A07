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
        $lender = Lender::getDataLenderbyId($lender_id);
        $products = Product::getDataProductsbyLenderId($lender_id);
        return view('superadmin.V_HalDataAlatSA', compact('products', 'lender'));
    }
}
