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
use Illuminate\Support\Facades\Validator;

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
        if (!$rentTransactions->isEmpty()) {
            foreach ($rentTransactions as $transaction) {
                $endDate = Carbon::createFromFormat('Y-m-d', $transaction->return_date)->addDay()->format('Y-m-d');
                $events[] = [
                    'title' => 'Disewa',
                    'start' => $transaction->rent_date,
                    'end' => $endDate,
                    'product_id' => $transaction->product_id,
                ];
            }
        }
        $product = Product::getDataProductsbyId($productId);

        return view('borrowers.V_FormSewaAlat', compact('product', 'events', 'borrower'));
    }

    public function SewaAlatPetani(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        $productId = Crypt::decrypt($request->input('product_id'));
        $borrowerId = $borrower->id;

        $messages = [
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pemgembalian hanya boleh sama dengan atau lebih dari tanggal awal.'
        ];

        $validator = Validator::make($request->all(), [
            'rent_date' => 'required|date',
            'return_date' => [
                'required',
                'date',
                'after_or_equal:rent_date',
                function ($attribute, $value, $fail) use ($request) {
                    $maxDiff = 2;
                    $rentDate = \Carbon\Carbon::parse($request->input('rent_date'));
                    $returnDate = \Carbon\Carbon::parse($value);
                    $diffInDays = $rentDate->diffInDays($returnDate);

                    if ($diffInDays > $maxDiff) {
                        $fail("Maaf, maksimal lama penyewaan atau peminjaman adalah 3 hari.");
                    }
                },
            ],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::getDataProductsbyId($productId);

        $rentDate = $request->input('rent_date');
        $returnDate = $request->input('return_date');

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
            $product = Product::findOrFail($productId);
            $product->is_rented = 'yes';
            $product->save();
        }

        RentTransaction::postDataRentTransaction($borrowerId, $productId, $rentDate, $returnDate);

        return redirect('HalPenyewaanPetani')->with('success', 'Penyewaan berhasil dibuat!');
    }
}
