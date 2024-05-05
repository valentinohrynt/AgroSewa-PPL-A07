<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPenggunaSA_Petani extends Controller
{
    public function setHalDataAkunPenggunaSA_Petani(Request $request, $borrower_id)
    {
        $borrowerId = Crypt::decrypt($borrower_id);
        $borrower = Borrower::getDataBorrowerbyId($borrowerId);
        $userId = $borrower->user_id;
        $user = User::getDataUserbyId($userId);
        return view('superadmin.V_HalDataAkunPenggunaSA_Petani', compact('borrower', 'user'));
    }
}
