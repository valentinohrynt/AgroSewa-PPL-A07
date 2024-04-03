<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FormEditDataAlat extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'product_description' => 'max:255',
            'price' => 'required|numeric',
            'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file types and size
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->product_description = $request->product_description;
            $product->price = $request->price;

            $user = Auth::user();
            $lender = Lender::where('user_id', $user->id)->first();

            if ($request->hasFile('product_img')) {
                $image = $request->file('product_img');
                $extension = $request->file('product_img')->getClientOriginalExtension();
                $imageName = 'P' . str_pad($product->id, 3, '0', STR_PAD_LEFT) . '.' . $extension;
                $request->file('product_img')->storeAs('product_img', $imageName);
                $product->product_img = $imageName;
            }

            $product->lender_id = $lender->id;
            $product->save();

            return redirect()->back()->with('success', 'Alat berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
