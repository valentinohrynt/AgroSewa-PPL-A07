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
    public function TambahDataAlat( Request $request ) { // fungsi untuk menambah data alat
        $user = Auth::user(); // ambil data user yang sedang login
        $userId = $user -> id; // ambil id user yang sedang login
        $lender = Lender::getDataLenderbyUserId( $userId ); // ambil data peminjam
        $lenderId = $lender->id; // ambil id lender
        $productName = $request -> name; // ambil data nama
        $productDesc = $request -> product_description; // ambil data deskripsi
        $productPrice = $request -> price; // ambil data harga
        $messages = [ // mengatur pesan error saat validasi
            'name.required' => 'Nama alat harus diisi.',
            'price.required' => 'Harga sewa alat harus diisi.',
            'product_img.required' => 'Gambar alat harus diisi.',
            'product_img.image' => 'File gambar harus berupa gambar (bukan video dan file dokumen lainnya).',
            'product_img.mimes' => 'Format gambar yang dapat diunggah adalah .jpeg, .png, .jpg .',
            'product_img.max' => 'Ukuran maksimal gambar alat adalah 2MB.'
        ];

        $validator = Validator::make( $request->all(), [ // validasi data 
            'name' => 'required', // harus diisi
            'product_description' => 'max:255', // maksimal 255 karakter
            'price' => 'required|numeric', // harus diisi dan harus angka
            'product_img' => 'required|image|mimes:jpeg,png,jpg|max:2048', // harus diisi dan harus gambar
        ], $messages );

        if ( $validator->fails() ) { // jika validasi gagal
            return redirect()->back()->withErrors( $validator )->withInput()->with( 'addItemErrors', true ); // kembalikan ke halaman tambah item dengan pesan error validasi
        }
        // jika validasi sukses 
        try {
            $product = Product::postDataProducts( $productName, $productDesc, $productPrice, $lenderId ); // simpan data product
            $image = $request->product_img; // ambil data gambar
            if ( $image ) { // jika gambar ada
                $extension = $image->getClientOriginalExtension(); // ambil ekstensi
                $imageGD = imagecreatefromstring( file_get_contents( $image->getPathname() ) ); // buat objek gambar
                if ( imageistruecolor( $imageGD ) ) { // jika gambar truecolor atau tidak transparan
                    $imageName = $product->product_code . '.webp'; // buat nama file baru, ganti ekstensi ke webp
                    if ( function_exists( 'imagewebp' ) ) { // cek apakah fungsi imagewebp ada
                        $directory = storage_path('app/public/product_img/'); // buat direktori
                        if (!file_exists($directory)) { // cek apakah direktori ada
                            mkdir($directory, 0777, true); // buat direktori
                        }
                        // jika direktori / folder ada
                        imagewebp( $imageGD, storage_path( 'app/public/product_img/' . $imageName ), 40 ); // simpan gambar ke direktori public dengan quality 40%
                    } else { // jika fungsi imagewebp tidak ada
                        $imageName = $product->product_code . '.' . $extension; // buat nama file baru
                        $image->storeAs('product_img', $imageName); // simpan gambar
                    }
                    $product->product_img = $imageName; // simpan nama file ke database
                } else { // jika gambar transparan
                    $imageName = $product->product_code . '.' . $extension; // buat nama file baru
                    $image->storeAs( 'product_img', $imageName ); // simpan gambar
                    $product->product_img = $imageName; // simpan nama file ke database
                }
                $product->save(); // simpan
                imagedestroy( $imageGD ); // hapus objek gambar temp (temporary)
            }
            return redirect()->back()->with( 'success', 'Sukses, data berhasil ditambah' ); // kembalikan ke halaman tambah prduk dengan pesan sukses
        } catch ( \Exception $e ) {     // jika terjadi kesalahan
            Log::error( $e->getMessage() ); // log error

            return redirect()->back()->with( 'error', 'Gagal, data tidak valid' ); // kembalikan ke halaman tambah prduk dengan pesan error
        }
    }
}
