<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use Illuminate\Http\Request;

class C_HalAkunKelompokTaniPemerintah extends Controller
{
    public function setHalAkunKelompokTaniPemerintah()
    {
        $lenders = Lender::getAllDataLender();
        return view('government.V_HalAkunKelompokTaniPemerintah', ['lenders' => $lenders]);
    }

    public function HalDataAkunKelompokTaniPemerintah($lender_id)
    {
        return redirect()->route('HalDataAkunKelompokTaniPemerintah', ['lender_id' => $lender_id]);
    }

    public function TambahAkunKelompokTaniPemerintah()
    {
        return redirect()->route('TambahAkunKelompokTaniPemerintah');
    }

    public function EditAkunKelompokTaniPemerintah($lender_id)
    {
        return redirect()->route('EditAkunKelompokTaniPemerintah', ['lender_id' => $lender_id]);
    }
}
