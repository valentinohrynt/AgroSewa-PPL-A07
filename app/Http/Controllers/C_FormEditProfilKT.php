<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_FormEditProfilKT extends Controller
{
    public function setFormEditProfilKT() // fungsi untuk set form edit profil
    {
        $districts = District::orderBy('name')->get(); // mendapatkan data kecamatan (ini isinya daftar kecamatan di Jember, buat di combobox edit data profil yang pilih kecamatan)
        $villages = Village::orderBy('name')->get(); // mendapatkan data desa (buat di combobox edit data profil yang pilih desa)
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id;  // mendapatkan id user yang sedang login
        $lender = Lender::getDataLenderbyUserId($userId); // mendapatkan data lender berdasarkan id
        return view('lenders.V_FormEditProfilKT', compact('lender', 'user', 'villages', 'districts')); // return halaman FormEditProfilKT beserta data-data di atas
    }
    public function EditProfilKT(Request $request) // fungsi untuk edit profil
    {
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id; // mendapatkan id user yang sedang login
        $lender = Lender::getDataLenderbyUserId($userId); // mendapatkan data lender berdasarkan id

        $messages = [ // pesan validasi (ketika ada yang tidak memenuhi syarat pada validator, maka akan muncul pesan ini)
            'email.required' => 'Alamat Email harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'street.required' => 'Alamat harus diisi.',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Mohon maaf, username tersebut sudah digunakan',
            'email.email' => 'Mohon masukkan alamat email yang valid!',
            'email.unique' => 'Mohon maaf, alamat email tersebut sudah digunakan. ',
            'phone.regex' => 'Mohon masukkan nomor telepon yang valid! ',
            'oldPassword.required' => 'Kata sandi lama wajib diisi.',
            'newPassword.min' => 'Kata sandi baru minimal berisi 8 karakter.',
            'nik.required' => 'NIK harus diisi.',
            'nik.numeric' => 'NIK harus berupa angka.'
        ];

        $validator = Validator::make($request->all(), [ // validasi
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)], // validasi email, dimana email harus diisi, valid berbentuk email (contoh: 4hW9m@example.com), dan unique (email harus unik) namun boleh sama dengan email yang dipakai sebelumnya
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // validasi nomor hp, dimana nomor hp harus diisi, dan harus berupa angka
            'nik' => 'required|numeric', // validasi nik, dimana nik harus diisi, dan harus berupa angka
            'street' => 'required', // validasi alamat, dimana alamat harus diisi
            'oldPassword' => 'required', // validasi kata sandi lama, dimana kata sandi lama harus diisi
            'username' => ['required', Rule::unique('users')->ignore($userId)], // validasi username, dimana username harus diisi, dan unique (username harus unik) namun boleh sama dengan username yang dipakai sebelumnya
            'newPassword' => $request->filled('newPassword') ? 'min:8' : '' // validasi kata sandi baru, dimana kata sandi baru harus diisi, dan minimal berisi 8 karakter
        ], $messages); // proses validasi

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator); // kembalikan ke halaman sebelumnya dan menampilkan pesan validasi
        }
        // jika validasi berhasil
        if (Hash::check($request->input('oldPassword'), $user->password)) { // jika kata sandi lama sesuai dengan yang ada di database
            // Update data akun lender
            $lenderId = $lender->id; // mendapatkan id lender yang sedang login
            $phone = $request->input('phone'); // mendapatkan inputan nomor hp
            $street = $request->input('street'); // mendapatkan inputan alamat
            $village_id = $request->input('village_id');  // mendapatkan inputan id desa
            $nik = $request->input('nik'); // mendapatkan inputan nik
            Lender::putDataLender($lenderId, $nik, $phone, $street, $village_id); // proses update data
            if ($request->filled('newPassword') || $request->filled('email') || $request->input('username') !== $user->username) { // jika kata sandi baru diisi atau email diisi atau username berbeda dengan yang ada di database
                $newEmail = $request->input('email'); // mendapatkan inputan email
                $newUsername = $request->input('username'); // mendapatkan inputan username
                $newPassword = $request->input('newPassword'); // mendapatkan inputan kata sandi
                User::putDataUser($userId, $newUsername, $newPassword, $newEmail); // proses update data
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan'); // kembalikan ke halaman sebelumnya dan menampilkan pesan berhasil
        } else { // jika kata sandi lama tidak sesuai
            return redirect()->back()->with('error', 'Kata sandi lama Anda salah, silahkan coba lagi.'); // kembalikan ke halaman sebelumnya dan menampilkan pesan error
        }
    }
}
