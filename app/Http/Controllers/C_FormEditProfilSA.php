<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_FormEditProfilSA extends Controller
{
    public function setFormEditProfilSA() // fungsi untuk menampilkan halaman form edit profil superadmin
    {
        $districts = District::orderBy('name')->get(); // ambil data kecamatan untuk mengisi dropdown / dropbox
        $villages = Village::orderBy('name')->get(); // ambil data desa untuk mengisi dropdown / dropbox
        $user = Auth::user(); // ambil data user yang sedang login
        $userId = $user->id; // ambil id user yang sedang login
        $superadmin = Superadmin::getDataSuperadminbyUserId($userId); // ambil data superadmin berdasarkan id
        return view('superadmin.V_FormEditProfilSA', compact('superadmin', 'user', 'villages', 'districts')); // return halaman V_FormEditProfilSA beserta data-data di atas
    }
    public function EditProfilSA(Request $request) // fungsi untuk mengedit profil superadmin
    {
        $user = Auth::user(); // ambil data user yang sedang login
        $userId = $user->id; // ambil id user yang sedang login
        $superadmin = Superadmin::getDataSuperadminbyUserId($userId); // ambil data superadmin berdasarkan id

        $messages = [ // pesan validasi (ketika ada yang tidak memenuhi syarat pada validator, maka akan muncul pesan ini)
            'name.required' => 'Nama harus diisi.',
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

        $validator = Validator::make($request->all(), [ // validasi data yang diinputkan
            'name' => 'required', // nama harus diisi
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId),], // email harus diisi, valid berbentuk email (contoh: 4hW9m@example.com), dan unique (email harus unik) namun boleh sama dengan email yang dipakai oleh user ini sebelumnya
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // nomor hp harus diisi dan harus berupa angka dan harus diawali dengan 0 atau +62
            'street' => 'required', // alamat harus diisi
            'village_id' => 'required', // desa harus diisi
            'oldPassword' => 'required',   // kata sandi lama harus diisi
            'username' => ['required', Rule::unique('users')->ignore($userId)], // username harus diisi dan unique (username harus unik) namun boleh sama dengan username yang dipakai oleh user ini sebelumnya
            'newPassword' => $request->filled('newPassword') ? 'min:8' : '' // kata sandi baru tidak wajib diisi, namun jika diisi dan minimal 8 karakter
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator); // kembalikan ke halaman form edit profil superadmin beserta pesan validasi
        }
        // namun, jika validasi sukses
        if (Hash::check($request->input('oldPassword'), $user->password)) { // jika kata sandi lama sesuai dengan yang diinputkan
            // Update data akun superadmin 
            $superadminId = $superadmin->id; // ambil id superadmin
            $name = $request->input('name'); // ambil inputan nama
            $phone = $request->input('phone'); // ambil inputan nomor hp
            $street = $request->input('street'); // ambil inputan alamat
            $village_id = $request->input('village_id'); // ambil inputan desa
            Superadmin::putDataSuperadmin($superadminId, $name, $phone, $street, $village_id); // simpan data akun superadmin
            // Update kredensial login superadmin
            if ($request->filled('newPassword') || $request->filled('email') || $request->input('username') !== $user->username) { // jika kata sandi baru diisi atau email diisi atau username berubah, 
                $newEmail = $request->input('email'); // ambil inputan email
                $newUsername = $request->input('username'); // ambil inputan username
                $newPassword = $request->input('newPassword'); // ambil inputan kata sandi
                User::putDataUser($userId, $newUsername, $newPassword, $newEmail); // simpan data akun user
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan'); // kembalikan ke halaman form edit profil superadmin beserta pesan sukses
        } else { // jika kata sandi lama tidak sesuai
            return redirect()->back()->with('error', 'Kata sandi lama Anda salah, silahkan coba lagi.'); // kembalikan ke halaman form edit profil superadmin beserta pesan error
        }
    }
}
