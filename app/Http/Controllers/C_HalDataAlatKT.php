<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalDataAlatKT extends Controller
{
    public function setHalDataAlatKT()
    {
        // Alur diawali dengan mengambil data user yang sedang login
        $user = Auth::user(); //mengambil data user yang sedang login
        $userId = $user->id; //mengambil id user yang sedang login
        $lender = Lender::getDataLenderbyUserId($userId); //mengambil data lender berdasarkan id user yang sedang login
        $lenderId = $lender->id; //mengambil id lender yang sedang login
        $products = Product::getDataProductsbyLenderId($lenderId); //mengambil data products berdasarkan id lender yang sedang login

        return view('lenders.V_HalDataAlatKT', ['products' => $products]); //return halaman V_HalDataAlatKT dan $product agar dapat digunakan pada view
    }
}
