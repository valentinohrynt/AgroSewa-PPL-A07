<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepagePetani extends Controller
{
    public function setHomepagePetani(){
        return view("borrowers.HomepagePetani");
    }
    public function HalPenyewaanPetani(){
        return redirect("HalPenyewaanPetani");
    }
}
