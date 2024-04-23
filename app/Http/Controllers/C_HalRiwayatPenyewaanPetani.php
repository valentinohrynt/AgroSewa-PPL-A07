<?php

namespace App\Http\Controllers;

use App\Models\RentLog;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalRiwayatPenyewaanPetani extends Controller
{
    public function setHalRiwayatPenyewaanPetani(){
        $user = Auth::user();
        $userId = $user->id;
        $borrower = Borrower::getDataBorrowerbyUserId($userId);
        $borrowerId = $borrower -> id;
        $rentLogs = RentLog::getDataRentLogbyBorrowerId($borrowerId);
    
        return view('borrowers.V_HalRiwayatPenyewaanPetani', ['rentLogs' => $rentLogs]);
    }
}
