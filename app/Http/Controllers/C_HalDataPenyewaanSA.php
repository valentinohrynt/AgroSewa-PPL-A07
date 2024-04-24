<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class C_HalDataPenyewaanSA extends Controller
{
    public function setHalDataPenyewaanSA(Request $request)
    {
        $lender_id = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lender_id);
        $product = Product::getDataProductsbyLenderId($lender_id);
        $productIds = $product->pluck('id');
    
        $rentTransactions = RentTransaction::getDataRentTransactionbyProductIds($productIds);
    
        return view('superadmin.V_HalDataPenyewaanSA', compact('rentTransactions', 'lender'));
    }
}
