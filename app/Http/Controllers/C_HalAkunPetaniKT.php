<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use App\Models\Borrower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class C_HalAkunPetaniKT extends Controller
{
    public function setHalAkunPetaniKT() // Fungsi ini untuk menampilkan ke halaman akun petani
    {
        $user = Auth::user(); // mengambil data user yang sedang login
        $user_id = $user->id; // mengambil id user
        $lender = Lender::getDataLenderbyUserId($user_id); // mengambil data lender berdasarkan id user
        $lender_id = $lender->id; // mengambil id lender
        $borrowers = Borrower::getAllActiveDataBorrowerbyLenderId($lender_id); // mengambil data borrower berdasarkan id lender
        return view('lenders.V_HalAkunPetaniKT', compact('borrowers')); // mengembalikan view V_HalAkunPetaniKT beserta data borrowers
    }

    public function HalDataAkunPetaniKT($borrower_id) // Fungsi ini untuk redirect / berpindah ke halaman data akun petani
    {
        return redirect()->route('HalDataAkunPetaniKT', ['borrower_id' => $borrower_id]); // mengembalikan ke halaman data akun petani bersamaan dengan id borrower
    }

    public function BlokirAkunPetani(Request $request, $borrower_id) // Fungsi ini untuk memblokir akun petani
    {
        $borrower = Borrower::getDataBorrowerbyId($borrower_id); // mengambil data borrower berdasarkan id
        $user_id = $borrower->user_id; // mengambil id user
        User::patchStatustoInactive($user_id); // memblokir akun user
        return redirect()->back()->with('success', 'Akun petani berhasil diblokir!'); // mengembalikan ke halaman akun petani 
    }
}
