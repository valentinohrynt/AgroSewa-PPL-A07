<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class HalDataPenyewaanSA extends Controller
{
    public function setHalDataPenyewaanSA(Request $request)
    {
        $lender_id = $request->input('lender_id');
        $lender = Lender::findOrFail($lender_id);
        $productIds = Product::whereHas('lender', function ($query) use ($lender_id) {
            $query->where('id', $lender_id);
        })->pluck('id');
    
        $rentTransactions = RentTransaction::with('product', 'borrower')
            ->whereIn('product_id', $productIds)
            ->where('is_completed', 'no')
            ->get();
    
        return view('superadmin.HalDataPenyewaanSA', compact('rentTransactions', 'lender'));
    }
}
