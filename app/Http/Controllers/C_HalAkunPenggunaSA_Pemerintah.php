<?php

namespace App\Http\Controllers;

use App\Models\Government;
use Illuminate\Http\Request;

class C_HalAkunPenggunaSA_Pemerintah extends Controller
{
    public function setHalAkunPenggunaSA_Pemerintah()
    {
        $government = Government::getAllDataGovernment();
        return view('superadmin.V_HalAkunPenggunaSA_Pemerintah', ['government' => $government]);
    }
    public function HalDataAkunPenggunaSA_Pemerintah($government_id)
    {
        return redirect()->route('HalDataAkunPenggunaSA_Pemerintah', ['government_id' => $government_id]);
    }
    public function TambahAkunPemerintah()
    {
        return redirect()->route('TambahAkunPemerintah');
    }
}
