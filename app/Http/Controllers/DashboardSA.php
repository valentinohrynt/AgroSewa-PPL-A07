<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RentTransaction;
use App\Http\Controllers\Controller;

class DashboardSA extends Controller
{
    public function setDashboardSA(){

        $countofTRT= RentTransaction::whereDate('rent_date',now()->toDateString())->where('is_completed', 'no')->count();
        $countofTNU = User::whereDate('created_at', now()->toDateString())->where('email_verified_at', true)->count();
        $countofART= RentTransaction::all()->count();
        $countofAU = User::all()->count();

        return view('superadmin.DashboardSA', compact('countofTRT', 'countofTNU', 'countofART','countofAU'));
    }
    public function HalPenyewaanSA(){
        return redirect('HalPenyewaanSA');
    }
}
