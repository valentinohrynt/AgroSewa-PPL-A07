<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class C_FormEditDataAlat extends Controller
{
    public function EditDataAlat(Request $request, $id)
    {
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
        $productName = $request->name;
        $productDesc = $request->product_description;
        $productPrice = $request->price;
        $product = Product::getDataProductsbyId($id);
        $messages = [
            'name.required' => 'Nama alat harus diisi.',
            'price.required' => 'Harga sewa alat harus diisi.',
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
            return redirect()->back()->withErrors($validator)->with('editItemErrors', true);
        }

        try {
            if ($request->hasFile('product_img')) {
                $image = $request->product_img;
                $extension = $image->getClientOriginalExtension();
                $imageName = $product->product_code. '.' . $extension;
                $image->storeAs('product_img', $imageName);
                Product::patchDataProducts($id, $productName, $productDesc, $productPrice, $lenderId, $imageName);
            } else {
                Product::patchDataProducts($id, $productName, $productDesc, $productPrice, $lenderId, null);
            }
            return redirect()->back()->with('success', 'Sukses, data berhasil diedit');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Gagal, data tidak valid');
        }
    }
}
