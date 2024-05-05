<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_Petani extends Controller
{
    public function setHalAkunPenggunaSA_Petani()
    {
        $borrowers = Borrower::getAllDataBorrower();
        return view ('superadmin.V_HalAkunPenggunaSA_Petani', ['borrowers'=> $borrowers]);
    }
    public function HalDataAkunPenggunaSA_Petani($borrower_id)
    {
        return redirect()->route('HalDataAkunPenggunaSA_Petani', ['borrower_id' => $borrower_id]);
    }
}
