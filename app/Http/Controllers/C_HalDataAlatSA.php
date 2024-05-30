<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C_HalDataAlatSA extends Controller
{
    public function setHalDataAlatSA(Request $request){ // set halaman data alat
        
        $lender_id = $request->input('lender_id'); // mengambil id dari input (dalam konteks ini input type hidden di view)
        $lender = Lender::getDataLenderbyId($lender_id); // mengambil data lender berdasarkan lender_id
        $products = Product::getDataProductsbyLenderId($lender_id); // mengambil data product berdasarkan id lender
        return view('superadmin.V_HalDataAlatSA', compact('products', 'lender')); // mengembalikan view V_HalDataAlatSA beserta data product dan data lender
    }
}
