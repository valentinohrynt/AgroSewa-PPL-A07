<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Auth;

class RentTransactionController extends Controller
{
    public function showRentTransactions()
    {
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
      
        $productIds = Product::where('lender_id', $lender->id)->pluck('id');
    
        $rentTransactions = RentTransaction::with('product', 'borrower')
            ->whereIn('product_id', $productIds)
            ->get();
    
        return view('lenders.penyewaan-poktan', ['rentTransactions' => $rentTransactions]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'rent_date' => 'required|date',
            'return_date' => 'required|date',
        ]);
        try {
            $transaction = RentTransaction::findOrFail($id);
            $transaction->update($request->all());
    
            return redirect()->back()->with('success', 'Transaksi berhasil di edit!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
    
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
    
}
