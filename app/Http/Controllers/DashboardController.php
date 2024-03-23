<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(){
        return view("home");
    }
    public function dashboardsuperadmin(){
        return view("dashboard-superadmin");
    }
    public function dashboardpemerintah(){
        return view("dashboard-pemerintah");
    }
    public function dashboardpoktan(){
        return view("dashboard-poktan");
    }
}