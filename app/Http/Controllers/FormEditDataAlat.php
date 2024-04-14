<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormEditDataAlat extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'product_description' => 'max:100',
            'price' => 'required|numeric',
            'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
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
