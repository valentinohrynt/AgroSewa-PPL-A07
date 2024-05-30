<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class C_FormEditDataAlat extends Controller {
    public function EditDataAlat( Request $request, $id ) { // fungsi untuk mengubah data alat
        $user = Auth::user(); // ambil data user yang sedang login
        $userId = $user->id; // ambil id user yang sedang login
        $lender = Lender::getDataLenderbyUserId( $userId ); // ambil data lender berdasarkan id user yang sedang login
        $lenderId = $lender->id; // ambil id lender yang sedang login
        $productName = $request->name; // ambil data name dari form inputan user
        $productDesc = $request->product_description; // ambil data product_description dari form inputan user
        $productPrice = $request->price; // ambil data price dari form inputan user
        $product = Product::getDataProductsbyId( $id ); // ambil data product berdasarkan id
        $messages = [ // atur pesan error saat validasi gagal / inputan user tidak memenuhi kriteria
            'name.required' => 'Nama alat harus diisi.',
            'price.required' => 'Harga sewa alat harus diisi.',
            'product_img.image' => 'File gambar harus berupa gambar (bukan video dan file dokumen lainnya).',
            'product_img.mimes' => 'Format gambar yang dapat diunggah adalah .jpeg, .png, .jpg .',
            'product_img.max' => 'Ukuran maksimal gambar alat adalah 2MB.'
        ];

        $validator = Validator::make( $request->all(), [ // validasi data inputan user
            'name' => 'required',
            'product_description' => 'max:255',
            'price' => 'required|numeric',
            'product_img' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], $messages );

        if ( $validator->fails() ) { // jika validasi gagal
            session( [ 'editItemId' => $id ] ); // simpan id item yang sedang diedit pada session
            return redirect()->back()->withErrors( $validator )->with( 'editItemErrors', true );  // kembalikan ke halaman edit item dengan pesan error validasi
        }
        // namun, jika validasi sukses
        try { // lakukan pengecekan
            if ( $request->hasFile( 'product_img' ) ) { // jika ada file gambar
                $image = $request->product_img; // ambil file gambar
                $extension = $image->getClientOriginalExtension(); // ambil ekstensi file
                $imageGD = imagecreatefromstring( file_get_contents( $image->getPathname() ) ); // buat objek gambar
                if ( imageistruecolor( $imageGD ) ) { // jika gambar bukan gambar transparan
                    $imageName = $product->product_code . '.webp'; // buat nama file gambar
                    if ( function_exists( 'imagewebp' ) ) { // cek apakah fungsi imagewebp tersedia
                        $directory = storage_path('app/public/product_img/'); // buat direktori atau folder baru dengan nama product_img
                        if (!file_exists($directory)) { // cek apakah direktori ada
                            mkdir($directory, 0777, true); // buat direktori atau folder baru
                        }
                        // jika sudah ada direktori / foldernya, maka
                        imagewebp( $imageGD, storage_path( 'app/public/product_img/' . $imageName ), 40 ); // simpan gambar dalam format webp dengan kualitas 40% dari gambar asli (disebut convert + compress gambar)
                    } else { // jika fungsi imagewebp tidak tersedia
                        $imageName = $product->product_code . '.' . $extension; // buat nama file gambar
                        $image->storeAs('product_img', $imageName); // simpan gambar
                    }
                    imagedestroy( $imageGD ); // hapus objek gambar
                    Product::patchDataProducts( $id, $productName, $productDesc, $productPrice, $lenderId, $imageName ); // update data product termasuk gambarnya juga
                } else { // jika gambar bukan gambar transparan
                    $imageName = $product->product_code . '.' . $extension; // buat nama file gambar
                    $image->storeAs( 'product_img', $imageName ); // simpan gambar
                    imagedestroy( $imageGD ); // hapus objek gambar
                    Product::patchDataProducts( $id, $productName, $productDesc, $productPrice, $lenderId, $imageName ); // update data product termasuk gambarnya juga
                }
            } else { // jika tidak ada file gambar
                Product::patchDataProducts( $id, $productName, $productDesc, $productPrice, $lenderId, null ); // update data product tanpa gambar
            }
            return redirect()->back()->with( 'success', 'Sukses, data berhasil diedit' ); // kembalikan ke halaman edit item dengan pesan sukses
        } catch ( \Exception $e ) { // jika terjadi kesalahan
            Log::error( $e->getMessage() ); // log error
            return redirect()->back()->with( 'error', 'Gagal, data tidak valid' ); // kembalikan ke halaman edit item dengan pesan error
        }
    }
}
