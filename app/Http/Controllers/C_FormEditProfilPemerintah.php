<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_FormEditProfilPemerintah extends Controller
{
    public function setFormEditProfilPemerintah() // Form Edit Profil Pemerintah
    {
        $districts = District::orderBy('name')->get(); // mengambil data kecamatan untuk mengisi dropdown / dropbox
        $villages = Village::orderBy('name')->get(); // mengambil data desa untuk mengisi dropdown / dropbox
        $user = Auth::user(); // mengambil data user yang sedang login
        $userId = $user->id; // mengambil id user
        $government = Government::getDataGovernmentbyUserId($userId); // mengambil data pemerintah berdasarkan id
        return view('government.V_FormEditProfilPemerintah', compact('government', 'user', 'villages', 'districts')); // mengembalikan view V_FormEditProfilPemerintah dengan $government, $user, $villages, $districts
    }
    public function EditProfilPemerintah(Request $request) // Edit Profil Pemerintah
    {
        $user = Auth::user(); // mengambil data user yang sedang login
        $userId = $user->id; // mengambil id user
        $government = Government::getDataGovernmentbyUserId($userId); // mengambil data pemerintah berdasarkan id

        $messages = [ // menyiapkan pesan error validasi
            'email.required' => 'Alamat Email harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'street.required' => 'Alamat harus diisi.',
            'village_id.required' => 'Desa harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan, silahkan gunakan username lainnya',
            'email.email' => 'Mohon masukkan alamat email yang valid!',
            'email.unique' => 'Mohon maaf, alamat email tersebut sudah digunakan. ',
            'phone.regex' => 'Mohon masukkan nomor telepon yang valid! ',
            'oldPassword.required' => 'Kata sandi lama wajib diisi.',
            'newPassword.min' => 'Kata sandi baru minimal berisi 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [ // validasi
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId),], // validasi email dimana email harus diisi, valid berbentuk email (contoh: 4hW9m@example.com), dan unique (email harus unik) namun boleh sama dengan email yang dipakai oleh user ini sebelumnya
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // validasi nomor hp yang dimasukkan harus berupa angka dan harus diawali dengan 0 atau +62
            'street' => 'required', // validasi alamat dimana alamat harus diisi
            'village_id' => 'required', // validasi desa dimana desa harus diisi
            'oldPassword' => 'required', // validasi kata sandi lama
            'username' => ['required', Rule::unique('users')->ignore($userId)], // validasi username dimana username harus diisi, unique (username harus unik) namun boleh sama dengan username yang dipakai oleh user ini sebelumnya
            'newPassword' => $request->filled('newPassword') ? 'min:8' : '' // validasi kata sandi baru
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator); // kembalikan ke form dengan pesan error
        }

        if (Hash::check($request->input('oldPassword'), $user->password)) { // jika kata sandi lama sesuai
            // Update data akun government
            $governmentId = $government->id; // mengambil id pemerintah
            $phone = $request->input('phone'); // mengambil nomor hp
            $street = $request->input('street'); // mengambil alamat
            $village_id = $request->input('village_id'); // mengambil id desa
            Government::putDataGovernment($governmentId, $phone, $street, $village_id); // memperbarui data
            // Update kredensial login government
            if ($request->filled('newPassword') || $request->filled('email') || $request->input('username') !== $user->username) { // jika kata sandi baru atau email diisi atau username berubah dari yang sebelumnya 
                $newEmail = $request->input('email'); // mengambil email
                $newUsername = $request->input('username');  // mengambil username
                $newPassword = $request->input('newPassword'); // mengambil kata sandi
                User::putDataUser($userId, $newUsername, $newPassword, $newEmail);  // memperbarui data
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan'); // kembalikan ke form dengan pesan sukses
        } else { // jika kata sandi lama tidak sesuai
            return redirect()->back()->with('error', 'Kata sandi lama Anda salah, silahkan coba lagi.'); // kembalikan ke form dengan pesan error
        }
    }
}
