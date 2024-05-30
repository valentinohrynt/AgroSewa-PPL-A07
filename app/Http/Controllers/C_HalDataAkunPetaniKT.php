<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPetaniKT extends Controller
{
    public function setHalDataAkunPetaniKT($borrower_id) // Fungsi ini untuk menampilkan data borrower / petani oleh kelompok tani
    {
        $borrowerId = Crypt::decrypt($borrower_id); // decrypt id borrower
        $borrower = Borrower::getDataBorrowerbyId($borrowerId); // Mengambil data borrower berdasarkan id
        $userId = $borrower->user_id; // Mengambil id user dari data borrower
        $user = User::getDataUserbyId($userId); // Mengambil data user berdasarkan id
        return view('lenders.V_HalDataAkunPetaniKT', compact('borrower', 'user')); // menampilkan halaman data akun petani dengan bersamaan data borrower dan user
    }
}
