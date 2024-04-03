<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\RentLog;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Log;

class RentLogController extends Controller
{
    public function completeRent(Request $request)
    {
        $request->validate([
            'rent_transaction_id' => 'required',
            'total_price' => 'required',
            'actual_return_date' => 'required|date_format:Y-m-d H:i:s',
        ]);
    
        $rentTransactionId = $request->input('rent_transaction_id');
        $totalPrice = $request->input('total_price');
        $actualReturnDate = $request->input('actual_return_date');
        $parsedActualReturnDate = Carbon::parse($actualReturnDate);
    
        RentTransaction::where('id', $rentTransactionId)
            ->update(['is_completed' => 'yes']);

        $rentTransaction = RentTransaction::find($rentTransactionId);
        $product = Product::find($rentTransaction->product_id);
        $product->is_rented = 'no';
        $product->save();
    
        RentLog::create([
            'rent_transaction_id' => $rentTransactionId,
            'total_price' => $totalPrice,
            'actual_return_date' => $parsedActualReturnDate,
        ]);
        $request->session()->flash('success', 'Transaksi berhasil diselesaikan dan ditambahkan ke Riwayat');
        return redirect()->back();
    }
}