<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class C_FormEditSewaAlat extends Controller
{
    public function EditSewaAlat(Request $request, $id)
    {
        $messages = [
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pengembalian harus sama dengan atau lebih dari tanggal awal.'
        ];
        
        $validator = Validator::make($request->all(), [
            'rent_date' => 'required|date',
            'return_date' => [
                'required',
                'date',
                'after_or_equal:rent_date',
                function ($attribute, $value, $fail) use ($request) {
                    $maxDiff = 2;
                    $rentDate = Carbon::parse($request->input('rent_date'));
                    $returnDate = Carbon::parse($value);
                    $diffInDays = $rentDate->diffInDays($returnDate);

                    if ($diffInDays > $maxDiff) {
                        $fail("Maaf, maksimal lama penyewaan atau peminjaman adalah 3 hari.");
                    }
                },
            ],
        ], $messages);
        
        if ($validator->fails()) {
            session(['editTransactionId' => $id]);
            return redirect()->back()->withErrors($validator)->withInput()->with('editTransactionErrors', true);
        }

        $rentDate = $request->rent_date;
        $returnDate = $request->return_date;

        $overlappingAppointments = RentTransaction::getDataRentTransactionbyProductId($id)
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
            return redirect()->back()->with('error','Maaf, alat ini sudah dibooking oleh pengguna lain pada tanggal tersebut. Silahkan masukkan tanggal lainnya');
        }

        if (Carbon::parse($rentDate)->isToday()) {
            $product = Product::findOrFail($id);
            $product->is_rented = 'yes';
            $product->save();
        }
        
        try {
            RentTransaction::patchRentDateandReturnDate($id, $rentDate, $returnDate);

            return redirect()->back()->with('success', 'Sukses, data berhasil diedit');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return redirect()->back()->with('error', 'Gagal, data tidak valid');
        }
    }
}
