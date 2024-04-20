<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class C_FormTambahDataAlat extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama alat harus diisi.',
            'price.required' => 'Harga sewa alat harus diisi.',
            'product_img.required' => 'Gambar alat harus diisi.',
            'product_img.image' => 'File gambar harus berupa gambar (bukan video dan file dokumen lainnya).',
            'product_img.mimes' => 'Format gambar yang dapat diunggah adalah .jpeg, .png, .jpg, .gif .',
            'product_img.max' => 'Ukuran maksimal gambar alat adalah 2MB.'
        ];
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'product_description' => 'max:255',
            'price' => 'required|numeric',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addItemErrors', true);
        }

        try {
            $latestProduct = Product::latest()->first();
            $latestCode = $latestProduct ? $latestProduct->product_code : 'P000';
    
            $newCode = 'P' . str_pad(intval(substr($latestCode, 1)) + 1, 3, '0', STR_PAD_LEFT);
            $user = Auth::user();
            $lender = Lender::where('user_id', $user->id)->first();
            $imageName = '';
            if ($request->hasFile('product_img')) {
                $image = $request->file('product_img');
                $extension = $request->file('product_img')->getClientOriginalExtension();
                $imageName = $newCode . '.' . $extension;
                $request->file('product_img') -> storeAs('product_img', $imageName);
            }
            $request['product_img'] = $imageName;

            $product = Product::create([
                'name' => $request->name,
                'product_code' => $newCode,
                'product_description' => $request->product_description,
                'product_img' => $imageName,
                'price' => $request->price,
                'lender_id' => $lender->id,
            ]);
            $product->save();
            return redirect()->back()->with('success', 'Sukses, data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return redirect()->back()->with('error', 'Gagal, data tidak valid');
        }
    }
}
