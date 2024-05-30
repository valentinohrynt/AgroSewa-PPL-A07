<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Lender;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;//untuk menetapkan kriteria validasi custom
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class C_FormEditAkunKelompokTaniPemerintah extends Controller
{
    public function setFormEditAkunKelompokTaniPemerintah($lender_id) // set form edit akun kelompok tani pemerintah
    {
        $lenderId = Crypt::decrypt($lender_id); // decrypt id lender yang dikirim dari controller C_HalAkunKelompokTaniPemerintah, tepatnya pada method EditAkunKelompokTaniPemerintah($lender_id)
        $lender = Lender::getDataLenderbyId($lenderId);  // mendapatkan data lender berdasarkan id
        $lender_userId = $lender->user_id; // mendapatkan id user yang terhubung dengan id lender
        $user = User::getDataUserbyId($lender_userId); // mendapatkan data user berdasarkan id
        $districts = District::orderBy('name')->get(); // mendapatkan data kecamatan (ini isinya daftar kecamatan di Jember, buat di combobox edit data kelompok tani yang pilih kecamatan)
        $villages = Village::orderBy('name')->get(); // mendapatkan data desa (buat di combobox edit data kelompok tani yang pilih desa)
        return view('government.V_FormEditAkunKelompokTaniPemerintah', compact('lender', 'user', 'villages', 'districts')); // return halaman FormEditAkunKelompokTaniPemerintah beserta data-data di atas
    }

    public function SimpanEditAkunKelompokTani(Request $request, $lender_id) // simpan edit akun kelompok tani
    {
        $lenderId = Crypt::decrypt($lender_id); // decrypt (awalnya dienkripsi, lalu disini di dekripsi atau decrypt) id lender yang dikirim dari view V_FormEditAkunKelompokTaniPemerintah
        $lender = Lender::getDataLenderbyId($lenderId); // mendapatkan data lender berdasarkan id
        $lender_userId = $lender->user_id; // mendapatkan id user yang terhubung dengan id lender
        $user = User::getDataUserbyId($lender_userId); // mendapatkan data user berdasarkan id
        $signedUser = Auth::user(); // mendapatkan data user yang sedang login
        $messages = [ // pesan validasi (ketika ada yang tidak memenuhi syarat pada validator, maka akan muncul pesan ini)
            'email.required' => 'Alamat Email harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'street.required' => 'Alamat harus diisi.',
            'village_id.required' => 'Desa harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan, silahkan gunakan username lainnya',
            'email.email' => 'Mohon masukkan alamat email yang valid!',
            'email.unique' => 'Mohon maaf, alamat email tersebut sudah digunakan. ',
            'phone.regex' => 'Mohon masukkan nomor telepon yang valid! ',
            'governmentPassword.required' => 'Kata sandi anda harus diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [ // validasi data inputan user   
            'email' => ['required', 'email', Rule::unique('users')->ignore($lender_userId),], // email harus diisi, harus valid, dan harus unique (yang ada di tabel user yang idnya sama dengan id user yang sedang login)
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // phone harus diisi, harus valid, dan harus 11 atau 12 digit
            'street' => 'required', // street harus diisi
            'village_id' => 'required', // village_id harus diisi
            'password' => $request->filled('password') ? 'min:8' : '', // password harus diisi (opsional), jika ada / diisi oleh user maka harus minimal 8 karakter 
            'governmentPassword' => 'required', // governmentPassword harus diisi (password milik pemerintah yang sedang mengubah data kelompok tani)
            'username' => ['required', Rule::unique('users')->ignore($userId)] // username harus diisi, harus unique (tidak boleh sama dengan username milik akun lainnya)
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal / ada inputan yang tidak memenuhi kriteria yang ditentukan pada $validator
            return redirect()->back()->withErrors($validator); // kembalikan ke halaman edit akun kelompok tani pemerintah
        }
        if (Hash::check($request->input('governmentPassword'), $signedUser->password)) { // jika password milik pemerintah yang sedang mengubah data kelompok tani cocok dengan password milik user yang sedang login
            $phone = $request->input('phone'); // mendapatkan inputan phone (nomor telepon)
            $street = $request->input('street'); // mendapatkan inputan street (alamat)
            $village_id = $request->input('village_id'); // mendapatkan inputan village_id (desa)
            Lender::putDataLender($lenderId, $phone, $street, $village_id); // update data kelompok tani
            if ($request->filled('password') || $request->input('username') !== $user->username) { // jika password diisi / ada inputan username yang berbeda dengan username milik kelompok tani yang sedang diedit datanya
                $newEmail = $request->input('email'); // mendapatkan inputan email
                $newUsername = $request->input('username'); // mendapatkan inputan username
                $newPassword = $request->input('newPassword'); // mendapatkan inputan password
                User::putDataUser($lender_userId, $newUsername, $newPassword, $newEmail); // update data user
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan'); // kembalikan ke halaman edit akun kelompok tani pemerintah pesan berhasil
        } else { // jika password milik pemerintah yang sedang mengubah data kelompok tani tidak cocok dengan password milik user yang sedang login
            return redirect()->back()->with('error', 'Kata sandi Anda salah, silahkan coba lagi.'); // kembalikan ke halaman edit akun kelompok tani pemerintah dengan pesan error
        }
    }
}
