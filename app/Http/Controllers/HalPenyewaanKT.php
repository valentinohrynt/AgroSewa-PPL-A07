<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HalPenyewaanKT extends Controller
{
    public function setHalPenyewaanKT()
    {
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
      
        $productIds = Product::where('lender_id', $lender->id)->pluck('id');
    
        $rentTransactions = RentTransaction::with('product', 'borrower')
            ->whereIn('product_id', $productIds)
            ->where('is_completed', 'no')
            ->get();
    
        return view('lenders.HalPenyewaanKT', ['rentTransactions' => $rentTransactions]);
    }
}
