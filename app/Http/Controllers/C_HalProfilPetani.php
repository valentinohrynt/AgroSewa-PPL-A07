<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalProfilPetani extends Controller
{
    public function setHalProfilPetani()
    {
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        return view('borrowers.V_HalProfilPetani', compact('borrower', 'user'));
    }
    public function FormEditProfilPetani()
    {
        return redirect('HalProfilPetani/FormEditProfilPetani');
    }
}
