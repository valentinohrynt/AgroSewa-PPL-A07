<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentTransaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class C_FormEditSewaAlat extends Controller
{
    public function update(Request $request, $id)
    {
        $messages = [
            'rent_date.required' => 'Tanggal awal harus diisi.',
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.after_or_equal' => 'Tanggal pengembalian harus sama dengan atau lebih dari tanggal awal.'
        ];
        
        $validator = Validator::make($request->all(), [
            'rent_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rent_date',
        ], $messages);

        if ($validator->fails()) {
            session(['editTransactionId' => $id]);
            return redirect()->back()->withErrors($validator)->withInput()->with('editTransactionErrors', true);
        }        
        
        try {
            $transaction = RentTransaction::findOrFail($id);
            $transaction->update($request->all());

            return redirect()->back()->with('success', 'Sukses, data berhasil diedit');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return redirect()->back()->with('error', 'Gagal, data tidak valid');
        }
    }
}
