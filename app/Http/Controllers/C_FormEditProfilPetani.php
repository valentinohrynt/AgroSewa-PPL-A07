<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\Borrower;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_FormEditProfilPetani extends Controller
{
    public function setFormEditProfilPetani() // fungsi untuk set Form Edit Profil Petani
    {
        $districts = District::orderBy('name')->get(); // mengambil data kecamatan untuk mengisi dropdown / dropbox
        $villages = Village::orderBy('name')->get(); // mengambil data desa untuk mengisi dropdown / dropbox
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id;  // mendapatkan id user yang sedang login
        $borrower = Borrower::getDataBorrowerbyUserId($userId); // mendapatkan data borrower berdasarkan id user
        return view('borrowers.V_FormEditProfilPetani', compact('borrower', 'user', 'villages', 'districts')); // mengembalikan view V_FormEditProfilPetani dengan $borrower, $user, $villages, $districts
    }
    public function EditProfilPetani(Request $request) // fungsi untuk Edit Profil Petani
    {
        $user = Auth::user(); // mendapatkan data user yang sedang login
        $userId = $user->id;  // mendapatkan id user yang sedang login
        $borrower = Borrower::getDataBorrowerbyUserId($userId); // mendapatkan data borrower berdasarkan id user

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
            'oldPassword.required' => 'Kata sandi lama wajib diisi.',
            'newPassword.min' => 'Kata sandi baru minimal berisi 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [ // validasi
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId),], // validasi email, dimana email harus diisi, valid berbentuk email (contoh: 4hW9m@example.com), dan unique (email harus unik) namun boleh sama dengan email yang dipakai sebelumnya
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // validasi nomor hp, dimana nomor hp harus diisi, dan valid berbentuk nomor hp
            'street' => 'required', // validasi alamat
            'village_id' => 'required', // validasi desa
            'oldPassword' => 'required', // validasi kata sandi lama
            'username' => ['required', Rule::unique('users')->ignore($userId)], // validasi username, dimana username harus diisi, unique (username harus unik) namun boleh sama dengan username yang dipakai sebelumnya
            'newPassword' => $request->filled('newPassword') ? 'min:8' : '' // validasi kata sandi baru
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator); // kembalikan ke halaman edit profil
        }

        if (Hash::check($request->input('oldPassword'), $user->password)) { // cek kata sandi, jika kata sandi lama benar
            // Update data akun borrower
            $borrowerId = $borrower->id; // mendapatkan id borrower
            $phone = $request->input('phone'); // mendapatkan inputan nomor hp
            $street = $request->input('street'); // mendapatkan inputan alamat
            $village_id = $request->input('village_id'); // mendapatkan inputan desa
            Borrower::putDataBorrower($borrowerId, $phone, $street, $village_id); // memperbarui data borrower
            // Update kredensial login borrower
            if ($request->filled('newPassword') || $request->filled('email') || $request->input('username') !== $user->username) { // jika kata sandi baru diisi atau email diisi atau username berubah dari yang sebelumnya
                $newEmail = $request->input('email'); // mendapatkan inputan email
                $newUsername = $request->input('username'); // mendapatkan inputan username
                $newPassword = $request->input('newPassword'); // mendapatkan inputan kata sandi
                User::putDataUser($userId, $newUsername, $newPassword, $newEmail); // memperbarui data user
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan'); // kembalikan ke halaman edit profil dengan pesan sukses
        } else { // jika kata sandi lama salah
            return redirect()->back()->with('error', 'Kata sandi lama Anda salah, silahkan coba lagi.'); // kembalikan ke halaman edit profil dengan pesan error
        }
    }
}
