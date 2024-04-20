<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lender;
use App\Models\Product;
use App\Models\RentLog;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class C_HalPenyewaanKT extends Controller
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
    
        return view('lenders.V_HalPenyewaanKT', ['rentTransactions' => $rentTransactions]);
    }

    public function completeRent(Request $request, $id)
    {
        $transaction = RentTransaction::findOrFail($id);
        $currentTime = Carbon::now();

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
            ->update(['is_completed' => 'yes']);

        $rentTransaction = RentTransaction::find($rentTransactionId);
        $product = Product::find($rentTransaction->product_id);
        $product->is_rented = 'no';
        $product->save();
    
        RentLog::create([
            'rent_transaction_id' => $rentTransactionId,
            'total_price' => $totalPrice,
            'actual_return_date' => $actualReturnDate,
        ]);
        $request->session()->flash('success', 'Transaksi berhasil diselesaikan dan ditambahkan ke Riwayat');
        return redirect()->back();
    }

    public function forceCancelTransaction(Request $request, $id)
    {
        $transaction = RentTransaction::findOrFail($id);
        $currentTime = Carbon::now();

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
    
        $rentTransactionId = $id;
        $totalPrice = $request->input('total_price');
        $actualReturnDate = $currentTime;
    
        RentTransaction::where('id', $rentTransactionId)
            ->update(['is_completed' => 'cancelled']);

        $rentTransaction = RentTransaction::find($rentTransactionId);
        $product = Product::find($rentTransaction->product_id);
        $product->is_rented = 'no';
        $product->save();
    
        RentLog::create([
            'rent_transaction_id' => $rentTransactionId,
            'total_price' => $decryptedTotalPrice,
            'actual_return_date' => $actualReturnDate,
        ]);
        return redirect('HalPenyewaanKT')->with('success', 'Penyewaan berhasil dibatalkan!');
    }

    public function HalDataAlatKT()
    {
        return redirect('HalDataAlatKT');
    }
}
