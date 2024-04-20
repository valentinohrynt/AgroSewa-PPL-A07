<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\RentLog;
use Illuminate\Support\Facades\Auth;

class C_HalRiwayatKT extends Controller
{
    public function setHalRiwayatKT(){
        $user = Auth::user();
        $lender = Lender::where('user_id', $user->id)->first();
    
        $rentLogs = RentLog::with(['rentTransaction.product', 'rentTransaction.borrower'])
            ->whereHas('rentTransaction', function ($query) use ($lender) {
                $query->where('is_completed', 'yes')->orWhere('is_completed', 'cancelled')
                      ->whereHas('product', function ($query) use ($lender) {
                          $query->where('lender_id', $lender->id);
                      });
            })
            ->get();
    
        return view('lenders.V_HalRiwayatKT', ['rentLogs' => $rentLogs]);
    }
}
