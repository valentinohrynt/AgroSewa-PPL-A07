<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class C_FormEditDataAlat extends Controller
{
    public function update(Request $request, $id)
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
            'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
        
        if ($validator->fails()) {
            session(['editItemId' => $id]);
            return redirect()->back()->withErrors($validator)->withInput()->with('editItemErrors', true);
        }

        try {
            $product = Product::findOrFail($id);
            $user = Auth::user();
            $lender = Lender::where('user_id', $user->id)->first();
            
            $data = [
                'name' => $request->name,
                'product_description' => $request->product_description,
                'price' => $request->price,
                'lender_id' => $lender->id,
            ];
            
            if ($request->hasFile('product_img')) {
                $image = $request->file('product_img');
                $extension = $image->getClientOriginalExtension();
                $imageName = 'P' . str_pad($product->id, 3, '0', STR_PAD_LEFT) . '.' . $extension;
                $image->storeAs('product_img', $imageName);
                $data['product_img'] = $imageName;
            }
            
            $product->update($data);

            return redirect()->back()->with('success', 'Sukses, data berhasil diedit');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Gagal, data tidak valid');
        }
    }
}
