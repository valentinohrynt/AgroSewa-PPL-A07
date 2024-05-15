<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_HomepageKT extends Controller
{
    public function setHomepageKT()
    {
        return view("lenders.V_HomepageKT");
    }
    public function HalAkunPetaniKT()
    {
        return redirect("HalAkunPetaniKT");
    }
    public function HalPenyewaanKT()
    {
        return redirect("HalPenyewaanKT");
    }
    public function HalPengajuanBantuanKT()
    {
        return redirect("HalPengajuanBantuanKT");
    }
    public function HalRiwayatPenyewaanKT()
    {
        return redirect("HalRiwayatPenyewaanKT");
    }
    public function HalProfilKT()
    {
        return redirect("HalProfilKT");
    }
}
