<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class C_FormSewaAlat extends Controller
{
    public function setFormSewaAlat(Request $request, $product_id)
    {
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        $productId = Crypt::decrypt($product_id);

        $rentTransactions = RentTransaction::getDataRentTransactionByProductId($productId)->get();
        $events = [];
        foreach ($rentTransactions as $transaction) {
            $endDate = Carbon::createFromFormat('Y-m-d', $transaction->return_date)->addDay()->format('Y-m-d');
            $events[] = [
                'title' => 'Disewa',
                'start' => $transaction->rent_date,
                'end' => $endDate,
                'product_id' => $transaction->product_id,
            ];
        }
        $product = Product::getDataProductsbyId($productId);

        return view('borrowers.V_FormSewaAlat', compact('product', 'events'));
    }

    public function SewaAlatPetani(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        $borrowerId = $borrower->id;

        $messages = [
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pemgembalian hanya boleh sama dengan atau lebih dari tanggal awal.'
        ];

        $request->validate([
            'rent_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rent_date'
        ], $messages);

        $rentDate = $request->input('rent_date');
        $returnDate = $request->input('return_date');
        $productId = $request->input('product_id');
        
        $overlappingAppointments = RentTransaction::getDataRentTransactionbyProductId($productId)
        ->where(function ($query) use ($rentDate, $returnDate) {
            $query->where(function ($q) use ($rentDate, $returnDate) {
                $q->where('rent_date', '<=', $rentDate)
                    ->where('return_date', '>=', $rentDate);
            })->orWhere(function ($q) use ($rentDate, $returnDate) {
                $q->where('rent_date', '<=', $returnDate)
                    ->where('return_date', '>=', $returnDate);
            })->orWhere(function ($q) use ($rentDate, $returnDate) {
                $q->where('rent_date', '>=', $rentDate)
                    ->where('return_date', '<=', $returnDate);
            });
        })->get();
    
        if ($overlappingAppointments->count() > 0) {
            return back()->with('status', 'error')->with('message', 'Maaf, alat ini sudah dibooking oleh pengguna lain pada tanggal tersebut. Silahkan masukkan tanggal lainnya');
        }

        if (Carbon::parse($rentDate)->isToday()) {
            $product = Product::find($request->input('product_id'));
            $product->is_rented = 'yes';
            $product->save();
        }

        RentTransaction::postDataRentTransaction($borrowerId, $productId, $rentDate, $returnDate);

        return redirect('HalPenyewaanPetani')->with('success', 'Penyewaan berhasil dibuat!');
    }
}
