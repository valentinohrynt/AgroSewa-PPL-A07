<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(){
        return view("borrowers.home");
    }
    public function dashboardsuperadmin(){
        return view("superadmin.dashboard-superadmin");
    }
    public function dashboardpemerintah(){
        return view("government.dashboard-pemerintah");
    }
    public function homepoktan(){
        return view("lenders.home-poktan");
    }
}