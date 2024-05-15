<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class C_HalDataAkunPetaniKT extends Controller
{
    public function setHalDataAkunPetaniKT($borrower_id)
    {
        $borrowerId = Crypt::decrypt($borrower_id);
        $borrower = Borrower::getDataBorrowerbyId($borrowerId);
        $userId = $borrower->user_id;
        $user = User::getDataUserbyId($userId);
        return view('lenders.V_HalDataAkunPetaniKT', compact('borrower', 'user'));
    }
}
