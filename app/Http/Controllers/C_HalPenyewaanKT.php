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
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
        $product = Product::getDataProductsbyLenderId($lenderId);
        $productIds = $product->pluck('id');

        $rentTransactions = RentTransaction::with('product', 'borrower')
            ->whereIn('product_id', $productIds)
            ->where('is_completed', 'no')
            ->get();

        return view('lenders.V_HalPenyewaanKT', ['rentTransactions' => $rentTransactions]);
    }

    public function SelesaiPenyewaan(Request $request, $id)
    {
        $rentTransactionId = $id;
        $currentTime = Carbon::now();
        $rentTransaction = RentTransaction::getDataRentTransactionbyId($rentTransactionId);

        $request->validate([
            'total_price' => 'required',
        ]);

        try {
            $decryptedTotalPrice = Crypt::decrypt($request->total_price);
        } catch (DecryptException $e) {
            return back()->with('error', 'Terjadi kesalahan, silahkan coba kembali');
        }

        $totalPrice = $decryptedTotalPrice;
        $actualReturnDate = $currentTime;

        RentTransaction::patchStatusRentTransactiontoYes($rentTransactionId);

        $product = Product::getDataProductsbyRentTransaction($rentTransaction);
        $productId = $product->id;
        Product::patchStatusProductstoNo($productId);

        RentLog::postDataRentLog($rentTransactionId, $totalPrice, $actualReturnDate);

        return redirect('HalPenyewaanKT')->with('success', 'Transaksi berhasil diselesaikan dan ditambahkan ke Riwayat');
    }

    public function BatalPenyewaan(Request $request, $id)
    {
        $rentTransactionId = $id;
        $currentTime = Carbon::now();
        $rentTransaction = RentTransaction::getDataRentTransactionbyId($rentTransactionId);

        $request->validate([
            'total_price' => 'required',
        ]);

        try {
            $decryptedTotalPrice = Crypt::decrypt($request->total_price);
        } catch (DecryptException $e) {
            return back()->with('error', 'Terjadi kesalahan, silahkan coba kembali');
        }

        $totalPrice = $decryptedTotalPrice;
        $actualReturnDate = $currentTime;

        RentTransaction::patchStatusRentTransactiontoCancelled($rentTransactionId);

        $product = Product::getDataProductsbyRentTransaction($rentTransaction);
        $productId = $product->id;
        Product::patchStatusProductstoNo($productId);

        RentLog::postDataRentLog($rentTransactionId, $totalPrice, $actualReturnDate);

        return redirect('HalPenyewaanKT')->with('success', 'Penyewaan berhasil dibatalkan!');
    }

    public function DataAlatKT()
    {
        return redirect('HalDataAlatKT');
    }
}
