<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_FormTambahAkunPenggunaSA_Pemerintah extends Controller
{
    public function setFormTambahAkunPenggunaSA_Pemerintah() // fungsi ini untuk menampilkan halaman form tambah akun pengguna pemerintah oleh superadmin
    {
        $districts = District::orderBy('name')->get(); // mengambil data kecamatan untuk dropdown
        $villages = Village::orderBy('name')->get(); // mengambil data desa untuk dropdown
        return view('superadmin.V_FormTambahAkunPenggunaSA_Pemerintah', compact('villages', 'districts')); // mengembalikan view V_FormTambahAkunPenggunaSA_Pemerintah dengan $villages, $districts
    }
    public function SimpanTambahAkunPemerintah(Request $request) // fungsi ini untuk melakukan tambah akun pemerintah
    {
        $messages = [ // mengatur pesan kesalahan validasi
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
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berisi 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [ // validasi inputan user 
            'name' => 'required', // harus diisi
            'email' => ['required', 'email', Rule::unique('users')], // email harus diisi dan harus unique 
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // nomor hp harus diisi dan harus valid (contoh: +6281234567890 atau 0123456789, intinya diawali 0 atau +62 dan panjangnya antara 9 sampai 12 angka) 
            'street' => 'required', // alamat harus diisi
            'village_id' => 'required', // desa harus diisi
            'password' => 'required|min:8', // kata sandi harus diisi dan minimal 8 karakter
            'username' => 'required|unique:users', // username harus diisi dan harus unique
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator)->withInput(); // kembalikan ke halaman form dengan pesan kesalahan
        }
        // jika validasi sukses
        $Email = $request->input('email'); // mengambil inputan email
        $Username = $request->input('username'); // mengambil inputan username
        $PasswordUnhashed = $request->input('password'); // mengambil inputan password

        $roleId = 2; // role id pemerintah
        $user = User::postDataUser($Username, $PasswordUnhashed, $Email, $roleId); // memanggil fungsi postDataUser

        $userId = $user; // mengambil id user
        $name = $request->input('name'); // mengambil inputan name
        $phone = $request->input('phone'); // mengambil inputan phone
        $street = $request->input('street'); // mengambil inputan street
        $village_id = $request->input('village_id'); // mengambil inputan village_id
        Government::postDataGovernment($name, $phone, $street, $village_id, $userId); // memanggil fungsi postDataGovernment

        return redirect()->back()->with('success', 'Data Akun Pemerintah berhasil dibuat'); // kembalikan ke halaman form dengan pesan sukses
    }
}
