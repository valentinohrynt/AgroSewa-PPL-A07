<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lender;
use App\Models\Product;
use App\Models\RentLog;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Encryption\DecryptException;

class C_HalPenyewaanPetani extends Controller
{
    public function setHalPenyewaanPetani()
    {
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        $borrowerId = $borrower->id;
        $borrowerLenderId = $borrower->lender_id;

        $lender = Lender::getDataLenderbyId($borrowerLenderId);
        $products = Product::getDataProductsbyLenderId($borrowerLenderId);
        $rentTransactions = RentTransaction::getDataRentTransactionbyBorrowerId($borrowerId);

        Session::put('borrower_id', $borrowerId);
        return view('borrowers.V_HalPenyewaanPetani',compact('lender', 'products', 'rentTransactions') );
    }

    public function BatalPenyewaanPetani(Request $request, $id)
    {
        $rentTransaction = RentTransaction::getDataRentTransactionbyId($id);

        $rentDate = Carbon::parse($rentTransaction->rent_date);
        $currentTime = Carbon::now();
        $differenceInDays = $currentTime->diffInDays($rentDate, false);
        if ($differenceInDays <= 0.000011574) {
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

        $totalPrice = $decryptedTotalPrice;
        $actualReturnDate = $currentTime;

        RentTransaction::patchStatusRentTransactiontoCancelled($id);

        $product = Product::getDataProductsbyRentTransaction($rentTransaction);
        $productId = $product->id;
        Product::patchStatusProductstoNo($productId);

        RentLog::postDataRentLog($id, $totalPrice, $actualReturnDate);
        return back()->with('success', 'Penyewaan berhasil dibatalkan!');
    }

    public function SewaAlat(Request $request)
    {
        $id = Crypt::encrypt($request -> product_id);
        return redirect()->route('FormSewaAlat',['product_id'=>$id]);
    }
}
