<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use App\Models\Borrower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class C_HalAkunPetaniKT extends Controller
{
    public function setHalAkunPetaniKT()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $lender = Lender::getDataLenderbyUserId($user_id);
        $lender_id = $lender->id;
        $borrowers = Borrower::getAllActiveDataBorrowerbyLenderId($lender_id);
        return view('lenders.V_HalAkunPetaniKT', compact('borrowers'));
    }

    public function HalDataAkunPetaniKT($borrower_id)
    {
        return redirect()->route('HalDataAkunPetaniKT', ['borrower_id' => $borrower_id]);
    }

    public function BlokirAkunPetani(Request $request, $borrower_id)
    {
        $borrower = Borrower::getDataBorrowerbyId($borrower_id);
        $user_id = $borrower->user_id;
        User::patchStatustoInactive($user_id);
        return redirect()->back()->with('success', 'Akun petani berhasil diblokir!');
    }
}
