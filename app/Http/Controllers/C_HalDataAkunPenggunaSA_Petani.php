<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPenggunaSA_Petani extends Controller
{
    public function setHalDataAkunPenggunaSA_Petani(Request $request, $borrower_id) // Fungsi ini untuk menampilkan data borrower / petani
    {
        $borrowerId = Crypt::decrypt($borrower_id); // decrypt id borrower
        $borrower = Borrower::getDataBorrowerbyId($borrowerId); // mengambil data borrower berdasarkan id
        $userId = $borrower->user_id; // mengambil id user 
        $user = User::getDataUserbyId($userId); // mengambil data user berdasarkan id
        return view('superadmin.V_HalDataAkunPenggunaSA_Petani', compact('borrower', 'user')); // menampilkan halaman data akun petani dengan bersamaan data borrower dan user
    }
}
