<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\RentLog;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Encryption\DecryptException;

class HalPenyewaanPetani extends Controller
{
    public function setHalPenyewaanPetani(){
        $userId = auth()->user()->id;
        $borrower = Borrower::where('user_id', $userId)->firstOrFail();
        $borrowerLenderId = $borrower->lender_id;
    
        $products = Product::where('lender_id', $borrowerLenderId)->get();
    
        $rentTransactions = RentTransaction::where('borrower_id', $borrower->id)
                                             ->where('is_completed', 'no')
                                             ->get();
        Session::put('borrower_id', $borrower->id);
        return view('borrowers.HalPenyewaanPetani', ['products' => $products, 'rentTransactions' => $rentTransactions]);
    }

    public function cancelTransaction(Request $request, $id)
    {
        $transaction = RentTransaction::findOrFail($id);
        
        $rentDate = Carbon::parse($transaction->rent_date);
        $currentTime = Carbon::now();
        $differenceInDays = $currentTime->diffInDays($rentDate, false);
        
        if ($differenceInDays <= 1) {
            return back()->with('error', 'Mohon maaf, Anda hanya dapat membatalkan penyewaan paling lambat satu hari sebelum hari awal peminjaman');
        }

        $request->validate([
            'total_price' => 'required',
        ]);

        try {
            $decryptedTotalPrice = Crypt::decrypt($request->total_price);
        } catch (DecryptException $e) {
            return back()->with('error', 'Terjadi kesalahan, silahkan coba kembali');
        }

        $rentTransactionId = $id;
        $totalPrice = $decryptedTotalPrice;
        $actualReturnDate = $currentTime;

        RentTransaction::where('id', $rentTransactionId)
            ->update(['is_completed' => 'cancelled']);

        $rentTransaction = RentTransaction::find($rentTransactionId);
        $product = Product::find($rentTransaction->product_id);
        $product->is_rented = 'no';
        $product->save();

        RentLog::create([
            'rent_transaction_id' => $rentTransactionId,
            'total_price' => $totalPrice,
            'actual_return_date' => $actualReturnDate,
        ]);
        return back()->with('success', 'Penyewaan berhasil dibatalkan!');
    }
}
