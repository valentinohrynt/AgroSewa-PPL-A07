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
    public function setFormSewaAlat(Request $request, $product_id) // fungsi ini digunakan untuk set form sewa alat
    {
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id; // mendapatkan id user yang sedang login
        $borrower = Borrower::getDataBorrowerbyUserId($userId); // mendapatkan data borrower berdasarkan id
        $productId = Crypt::decrypt($product_id); // mendapatkan id product

        $rentTransactions = RentTransaction::getDataRentTransactionByProductId($productId)->get(); // mendapatkan data rent transaction berdasarkan id
        $events = []; // inisialisasi array events, ini digunakan untuk mengisi kalender di halaman FormSewaAlat
        if (!$rentTransactions->isEmpty()) { // jika data rent transaction tidak kosong 
            foreach ($rentTransactions as $transaction) { // looping data rent transaction
                $endDate = Carbon::createFromFormat('Y-m-d', $transaction->return_date)->addDay()->format('Y-m-d'); // mendapatkan tanggal pengembalian + 1 hari
                $events[] = [ // menambahkan data ke array events
                    'title' => 'Disewa', // ini adalah tulisan yang muncul di kalender
                    'start' => $transaction->rent_date, // ini adalah tanggal awal 
                    'end' => $endDate, // ini adalah tanggal akhir
                    'product_id' => $transaction->product_id, // ini adalah id product
                ];
            }
        }
        $product = Product::getDataProductsbyId($productId); // mendapatkan data product berdasarkan id

        return view('borrowers.V_FormSewaAlat', compact('product', 'events', 'borrower')); // mengembalikan view V_FormSewaAlat dengan $product, $events, $borrower
    }

    public function SewaAlatPetani(Request $request) // fungsi ini digunakan untuk menyewa alat petani (menambahkan data ke table rent transaction)
    {
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id; // mendapatkan id user yang sedang login
        $borrower = Borrower::getDataBorrowerbyUserId($userId); // mendapatkan data borrower berdasarkan id
        $productId = Crypt::decrypt($request->input('product_id')); // decrypt id product yang dipilih oleh user (lalu dikirim ke controller dalam bentuk input) di halaman FormSewaAlat
        $borrowerId = $borrower->id; // mendapatkan id borrower

        $messages = [ // mengatur pesan validasi
            'rent_date.required' => 'Tanggal awal harus diisi.', 
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pemgembalian hanya boleh sama dengan atau lebih dari tanggal awal.'
        ];

        $validator = Validator::make($request->all(), [ // validasi inputan user 
            'rent_date' => 'required|date', // validasi inputan rent_date
            'return_date' => [ // validasi inputan return_date
                'required', // harus diisi
                'date', // harus berupa tanggal
                'after_or_equal:rent_date', // lebih dari atau sama dengan rent_date
                function ($attribute, $value, $fail) use ($request) { // validasi penyewaan maksimal 3 hari
                    $maxDiff = 2; // maksimal penyewaan 3 hari
                    $rentDate = \Carbon\Carbon::parse($request->input('rent_date')); // mendapatkan rent_date
                    $returnDate = \Carbon\Carbon::parse($value); // mendapatkan return_date
                    $diffInDays = $rentDate->diffInDays($returnDate); // menghitung lama penyewaan

                    if ($diffInDays > $maxDiff) { // jika lama penyewaan lebih dari 3 hari
                        $fail("Maaf, maksimal lama penyewaan atau peminjaman adalah 3 hari."); // pesan error
                    }
                },
            ],
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal 
            return redirect()->back()->withErrors($validator)->withInput(); // kembalikan ke halaman FormSewaAlat dengan pesan error validasi
        }

        $product = Product::getDataProductsbyId($productId); // mendapatkan data product berdasarkan id
 
        $rentDate = $request->input('rent_date'); // mendapatkan inputan rent_date
        $returnDate = $request->input('return_date'); // mendapatkan inputan return_date

        $overlappingAppointments = RentTransaction::getDataRentTransactionbyProductId($productId) // mendapatkan data rent transaction berdasarkan id product
            ->where(function ($query) use ($rentDate, $returnDate) { 
                $query->where(function ($q) use ($rentDate, $returnDate) {
                    $q->where('rent_date', '<=', $rentDate) // rent_date kurang dari atau sama dengan rent_date
                        ->where('return_date', '>=', $rentDate); // return_date lebih dari atau sama dengan rent_date
                })->orWhere(function ($q) use ($rentDate, $returnDate) {
                    $q->where('rent_date', '<=', $returnDate) // rent_date kurang dari atau sama dengan return_date
                        ->where('return_date', '>=', $returnDate); // return_date lebih dari atau sama dengan return_date
                })->orWhere(function ($q) use ($rentDate, $returnDate) { 
                    $q->where('rent_date', '>=', $rentDate) // rent_date lebih dari atau sama dengan rent_date
                        ->where('return_date', '<=', $returnDate); // return_date kurang dari atau sama dengan return_date
                });
            })->get(); // mengambil semua data rent transaction berdasarkan id product dan memenuhi kriteria yang diinginkan

        if ($overlappingAppointments->count() > 0) { // jika ada data rent transaction yang memenuhi kriteria
            return back()->with('status', 'error')->with('message', 'Maaf, alat ini sudah dibooking oleh pengguna lain pada tanggal tersebut. Silahkan masukkan tanggal lainnya'); // kembalikan ke halaman FormSewaAlat dengan pesan error
        }

        if (Carbon::parse($rentDate)->isToday()) { // jika rent_date adalah hari ini
            $product = Product::findOrFail($productId); // mendapatkan data product berdasarkan id
            $product->is_rented = 'yes'; // mengubah is_rented menjadi yes
            $product->save(); // menyimpan perubahan
        }

        RentTransaction::postDataRentTransaction($borrowerId, $productId, $rentDate, $returnDate); // memasukkan data ke table rent transaction

        return redirect('HalPenyewaanPetani')->with('success', 'Penyewaan berhasil dibuat!'); // kembalikan ke halaman HalPenyewaanPetani
    }
}
