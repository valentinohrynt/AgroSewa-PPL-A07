<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductAndRentTransactionController extends Controller
{
    public function showProductsAndRentTransactionstoPetani(Request $request)
    {
        $userId = auth()->user()->id;
        $borrower = Borrower::where('user_id', $userId)->firstOrFail();
        $borrowerLenderId = $borrower->lender_id;
    
        $products = Product::where('lender_id', $borrowerLenderId)->get();
    
        $rentTransactions = RentTransaction::where('borrower_id', $borrower->id)
                                             ->where('is_completed', 'no')
                                             ->get();
        Session::put('borrower_id', $borrower->id);
        return view('borrowers.penyewaan', ['products' => $products, 'rentTransactions' => $rentTransactions]);
    }
}
