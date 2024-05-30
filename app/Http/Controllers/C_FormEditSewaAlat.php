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
    public function EditSewaAlat(Request $request, $id) // fungsi untuk mengedit sewa alat
    {
        $messages = [ // pesan error validasi
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pengembalian harus sama dengan atau lebih dari tanggal awal.'
        ];
        
        $validator = Validator::make($request->all(), [ // validasi inputan user
            'rent_date' => 'required|date', // validasi inputan rent_date
            'return_date' => [
                'required', // return_date wajib diisi
                'date', // return_date harus berupa tanggal
                'after_or_equal:rent_date', // return_date harus lebih dari atau sama dengan rent_date
                function ($attribute, $value, $fail) use ($request) { // proses validasi maksimal lama penyewaan atau peminjaman adalah 3 hari
                    $maxDiff = 2; // maksimal lama penyewaan atau peminjaman adalah 3 hari
                    $rentDate = Carbon::parse($request->input('rent_date')); // rent_date
                    $returnDate = Carbon::parse($value); // return_date
                    $diffInDays = $rentDate->diffInDays($returnDate); // menghitung lama penyewaan atau peminjaman

                    if ($diffInDays > $maxDiff) { // jika lama penyewaan atau peminjaman lebih dari 3 hari
                        $fail("Maaf, maksimal lama penyewaan atau peminjaman adalah 3 hari."); // pesan error
                    }
                },
            ], // validasi inputan return_date 
        ], $messages);
        
        if ($validator->fails()) { // jika validasi gagal
            session(['editTransactionId' => $id]); // menyimpan id sewa alat yang sedang diedit pada session
            return redirect()->back()->withErrors($validator)->withInput()->with('editTransactionErrors', true); // kembalikan ke halaman edit sewa alat dengan pesan error validasi
        }

        $rentDate = $request->rent_date; // mengambil rent_date dan return_date dari form inputan user
        $returnDate = $request->return_date; // mengambil rent_date dan return_date dari form inputan user

        $overlappingAppointments = RentTransaction::getDataRentTransactionbyProductId($id) // mencari apakah ada transaksi sewa alat yang sama pada rent_date dan return_date yang diinput oleh user
        ->where(function ($query) use ($rentDate, $returnDate) { // dimana fungsi $query dijalankan untuk mengecek rent_date dan return_date 
            $query->where(function ($q) use ($rentDate, $returnDate) { // dimana fungsi $q dijalankan untuk mengecek rent_date dan return_date
                $q->where('rent_date', '<=', $rentDate) // rent_date harus kurang dari atau sama dengan rent_date yang diinput oleh user
                    ->where('return_date', '>=', $rentDate); // return_date harus lebih dari atau sama dengan rent_date yang diinput oleh user
            })->orWhere(function ($q) use ($rentDate, $returnDate) { // dimana fungsi $q dijalankan untuk mengecek rent_date dan return_date
                $q->where('rent_date', '<=', $returnDate) // rent_date harus kurang dari atau sama dengan return_date yang diinput oleh user
                    ->where('return_date', '>=', $returnDate); // return_date harus lebih dari atau sama dengan return_date yang diinput oleh user
            })->orWhere(function ($q) use ($rentDate, $returnDate) { // dimana fungsi $q dijalankan untuk mengecek rent_date dan return_date
                $q->where('rent_date', '>=', $rentDate) // rent_date harus lebih dari atau sama dengan rent_date yang diinput oleh user
                    ->where('return_date', '<=', $returnDate); // return_date harus kurang dari atau sama dengan return_date yang diinput oleh user
            });
        })->get(); // mengembalikan semua transaksi sewa alat yang terdapat pada rent_date dan return_date

        if ($overlappingAppointments->count() > 0) { // jika ada transaksi sewa alat yang terdapat pada rent_date dan return_date yang diinput oleh user
            return redirect()->back()->with('error','Maaf, alat ini sudah dibooking oleh pengguna lain pada tanggal tersebut. Silahkan masukkan tanggal lainnya'); // kembalikan ke halaman edit sewa alat dengan pesan error
        }

        if (Carbon::parse($rentDate)->isToday()) { // jika rent_date adalah hari ini
            $product = Product::findOrFail($id); // mencari produk berdasarkan id
            $product->is_rented = 'yes'; // mengubah is_rented pada row product yang sedang ingin disewa oleh user menjadi yes
            $product->save(); // menyimpan perubahan 
        }
        
        try { // mengatasi kesalahan yang muncul
            RentTransaction::patchRentDateandReturnDate($id, $rentDate, $returnDate); // memanggil fungsi patchRentDateandReturnDate pada model RentTransaction yang berfungsi untuk mengedit rent_date dan return_date

            return redirect()->back()->with('success', 'Sukses, data berhasil diedit'); // kembalikan ke halaman edit sewa alat dengan pesan sukses
        } catch (\Exception $e) { // menangkap kesalahan yang muncul
            Log::error($e->getMessage()); // log error
    
            return redirect()->back()->with('error', 'Gagal, data tidak valid'); // kembalikan ke halaman edit sewa alat dengan pesan error
        }
    }
}
