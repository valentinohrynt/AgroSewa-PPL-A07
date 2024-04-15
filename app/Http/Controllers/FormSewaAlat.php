<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FormSewaAlat extends Controller
{
    public function setFormSewaAlat(Request $request)
    {
        $user = Auth::user();
        $borrower = Borrower::where('user_id', $user->id)->first();
    
        $productId = $request->query('product_id');
        $product = Product::findOrFail($productId);
    
        $rentTransactions = RentTransaction::where('product_id', $productId)->where('is_completed', 'no')->get();

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

        return view('borrowers.FormSewaAlat', compact('product', 'events'));
    }
    
    public function store(Request $request)
    {
        $messages = [
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'rent_date.date' => 'Tanggal awal harus berupa tanggal yang valid.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.date' => 'Tanggal pengembalian harus berupa tanggal yang valid.',
            'return_date.different' => 'Tanggal pengembalian harus berbeda dengan tanggal sewa.'
        ];

        $request->validate([
            'rent_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rent_date'
        ], $messages);
        
        $rentDate = $request->input('rent_date');
        $returnDate = $request->input('return_date');

        $overlappingAppointments = RentTransaction::where('product_id', $request->input('product_id'))
        ->where(function ($query) use ($rentDate, $returnDate) {
            $query->where(function ($q) use ($rentDate, $returnDate) {
                $q->where('rent_date', '>=', $rentDate)
                    ->where('rent_date', '<=', $returnDate);
            })->orWhere(function ($q) use ($rentDate, $returnDate) {
                $q->where('return_date', '>=', $rentDate)
                    ->where('return_date', '<=', $returnDate);
            });
        })
        ->where('is_completed', 'no')
        ->get();

        if ($overlappingAppointments->count() > 0) {
            return back()->with('status', 'error')->with('message', 'Maaf, alat ini sudah dibooking oleh pengguna lain pada tanggal tersebut. Silahkan masukkan tanggal lainnya');
        }

        $user = Auth::user();
        $borrower = Borrower::where('user_id', $user->id)->first();

        if (Carbon::parse($rentDate)->isToday()) {
            $product = Product::find($request->input('product_id'));
            $product->is_rented = 'yes';
            $product->save();
        }
    
        RentTransaction::create([
            'borrower_id' => $borrower->id,
            'product_id' => $request->input('product_id'),
            'rent_date' => $rentDate,
            'return_date' => $returnDate
        ]);
    
        return redirect('HalPenyewaanPetani')->with('success', 'Penyewaan berhasil dibuat!');
    }
}