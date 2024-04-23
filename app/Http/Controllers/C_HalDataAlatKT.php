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
        
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
        $products = Product::getDataProductsbyLenderId($lenderId);
    
        return view('lenders.V_HalDataAlatKT', ['products' => $products]);
    }
}
