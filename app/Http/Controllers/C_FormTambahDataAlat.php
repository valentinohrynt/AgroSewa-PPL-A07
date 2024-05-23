<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class C_FormTambahDataAlat extends Controller {
    public function TambahDataAlat( Request $request ) {
        $user = Auth::user();
        $userId = $user -> id;
        $lender = Lender::getDataLenderbyUserId( $userId );
        $lenderId = $lender->id;
        $productName = $request -> name;
        $productDesc = $request -> product_description;
        $productPrice = $request -> price;
        $messages = [
            'name.required' => 'Nama alat harus diisi.',
            'price.required' => 'Harga sewa alat harus diisi.',
            'product_img.required' => 'Gambar alat harus diisi.',
            'product_img.image' => 'File gambar harus berupa gambar (bukan video dan file dokumen lainnya).',
            'product_img.mimes' => 'Format gambar yang dapat diunggah adalah .jpeg, .png, .jpg .',
            'product_img.max' => 'Ukuran maksimal gambar alat adalah 2MB.'
        ];

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'product_description' => 'max:255',
            'price' => 'required|numeric',
            'product_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], $messages );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput()->with( 'addItemErrors', true );
        }

        try {
            $product = Product::postDataProducts( $productName, $productDesc, $productPrice, $lenderId );

            $image = $request->product_img;
            if ( $image ) {
                $extension = $image->getClientOriginalExtension();
                $imageGD = imagecreatefromstring( file_get_contents( $image->getPathname() ) );
                if ( imageistruecolor( $imageGD ) ) {
                    $imageName = $product->product_code . '.webp';
                    if ( function_exists( 'imagewebp' ) ) {
                        $directory = storage_path('app/public/product_img/');
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }
                        imagewebp( $imageGD, storage_path( 'app/public/product_img/' . $imageName ), 40 );
                    } else {
                        $imageName = $product->product_code . '.' . $extension;
                        $image->storeAs('product_img', $imageName);
                    }
                    $product->product_img = $imageName;
                } else {
                    $imageName = $product->product_code . '.' . $extension;
                    $image->storeAs( 'product_img', $imageName );
                    $product->product_img = $imageName;
                }
                $product->save();
                imagedestroy( $imageGD );
            }
            return redirect()->back()->with( 'success', 'Sukses, data berhasil ditambah' );
        } catch ( \Exception $e ) {
            Log::error( $e->getMessage() );

            return redirect()->back()->with( 'error', 'Gagal, data tidak valid' );
        }
    }
}
