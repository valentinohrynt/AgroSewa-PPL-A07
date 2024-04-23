<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_HomepagePetani extends Controller
{
    public function setHomepagePetani(){
        return view("borrowers.V_HomepagePetani");
    }
    public function HalPenyewaanPetani(){
        return redirect("HalPenyewaanPetani");
    }
    public function HalRiwayatPenyewaanPetani(){
        return redirect("HalRiwayatPenyewaanPetani");
    }
}
