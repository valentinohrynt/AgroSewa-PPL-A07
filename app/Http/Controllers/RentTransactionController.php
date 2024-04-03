<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Auth;

class RentTransactionController extends Controller
{
    public function showRentTransactionstoPoktan()
    {
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
      
        $productIds = Product::where('lender_id', $lender->id)->pluck('id');
    
        $rentTransactions = RentTransaction::with('product', 'borrower')
            ->whereIn('product_id', $productIds)
            ->where('is_completed', 'no')
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

    public function showRentTransactionstoPetani()
    {
        $user = Auth::user();
        $borrower = Borrower::where('user_id', $user->id)->first();
        $rentTransactions = RentTransaction::where('borrower_id', $borrower->id)->get();
    
        return view('borrowers.penyewaan', ['rentTransactions' => $rentTransactions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rent_date' => 'required',
            'return_date' => 'required'
        ]);
        $user = Auth::user();
        $borrower = Borrower::where('user_id', $user->id)->first();
        if ($borrower->hasOngoingTransaction()) {
            return back()->with('status', 'error')->with('message', 'Maaf, Anda masih memiliki transaksi yang sedang berjalan.');
        }    
        RentTransaction::create([
            'borrower_id' => $borrower->id,
            'product_id' => $request->input('product_id'),
            'rent_date' => $request->input('rent_date'),
            'return_date' => $request->input('return_date')
        ]);

        return redirect('penyewaan');
    }
}