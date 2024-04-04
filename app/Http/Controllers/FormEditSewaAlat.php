<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FormEditSewaAlat extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'rent_date' => 'required|date',
            'return_date' => 'required|date|different:rent_date',
        ]);
        try {
            $transaction = RentTransaction::findOrFail($id);
            $transaction->update($request->all());
    
            return redirect()->back()->with('success', 'Transaksi berhasil di ubah!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
    
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}