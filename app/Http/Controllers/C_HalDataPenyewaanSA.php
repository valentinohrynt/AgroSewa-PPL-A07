<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class C_HalDataPenyewaanSA extends Controller
{
    public function setHalDataPenyewaanSA(Request $request) // fungsi ini berguna untuk set halaman data penyewaan oleh superadmin
    {
        $lender_id = $request->input('lender_id'); // mengambil lender_id dari input (dalam konteks ini input type hidden di view)
        $lender = Lender::getDataLenderbyId($lender_id); // mengambil data lender berdasarkan id
        $product = Product::getDataProductsbyLenderId($lender_id); // mengambil data product berdasarkan id
        $productIds = $product->pluck('id'); // mengambil id - id dari product
    
        $rentTransactions = RentTransaction::getDataRentTransactionbyProductIds($productIds); // mengambil data penyewaan berdasarkan id - id product
    
        return view('superadmin.V_HalDataPenyewaanSA', compact('rentTransactions', 'lender')); // mengembalikan view V_HalDataPenyewaanSA beserta data penyewaan dan data lender
    }
}
