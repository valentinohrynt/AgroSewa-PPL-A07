<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class C_FormTambahAkunKelompokTaniPemerintah extends Controller
{
    public function setFormTambahAkunKelompokTaniPemerintah() // fungsi ini untuk menampilkan halaman form tambah akun kelompok tani oleh pemerintah
    {
        $districts = District::orderBy('name')->get(); // mengambil data kecamatan untuk mengisi dropdown / dropbox
        $villages = Village::orderBy('name')->get(); // mengambil data desa untuk mengisi dropdown / dropbox
        return view('government.V_FormTambahAkunKelompokTaniPemerintah', compact('villages', 'districts')); // mengembalikan view V_FormTambahAkunKelompokTaniPemerintah
    }
    public function SimpanTambahAkunKelompokTani(Request $request) // fungsi ini untuk menyimpan data akun kelompok tani
    {
        $messages = [  // validasi data yang diinputkan
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
            'nik' => 'required', // harus diisi
            'email' => ['required', 'email', Rule::unique('users')], // validasi email, dimana email harus diisi, valid berbentuk email (contoh: 4hW9m@example.com), dan unique (email harus unik)
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'], // validasi nomor HP, dimana nomor HP harus diisi, dan harus dimulai dengan 0 atau +62
            'street' => 'required', // harus diisi
            'village_id' => 'required', // harus diisi
            'password' => 'required|min:8', // harus diisi, minimal 8 karakter
            'username' => 'required|unique:users', // validasi username, dimana username harus diisi, dan unique (username harus unik)
        ], $messages);

        if ($validator->fails()) { // jika validasi gagal
            return redirect()->back()->withErrors($validator)->withInput(); // kembalikan ke halaman form
        }

        // jika validasi sukses
        $Email = $request->input('email'); // mengambil inputan email
        $Username = $request->input('username'); // mengambil inputan username
        $PasswordUnhashed = $request->input('password'); // mengambil inputan password

        $roleId = 4; // role id 4 = lender
        $user = User::postDataUser($Username, $PasswordUnhashed, $Email, $roleId); // memanggil fungsi postDataUser (membuat data user baru) 

        $userId = $user; // mengambil id user
        $name = $request->input('name'); // mengambil inputan name
        $nik = $request->input('nik'); // mengambil inputan nik
        $phone = $request->input('phone'); // mengambil inputan phone
        $street = $request->input('street'); // mengambil inputan street
        $village_id = $request->input('village_id'); // mengambil inputan village_id
        Lender::postDataLender($name, $nik, $phone, $street, $village_id, $userId); // memanggil fungsi postDataLender (membuat data lender baru)

        return redirect()->back()->with('success', 'Data Akun Kelompok Tani berhasil dibuat'); // kembalikan ke halaman form tambah akun kelompok tani pemerintah dengan pemberitahuan data akun kelompok tani berhasil dibuat
    }
}
