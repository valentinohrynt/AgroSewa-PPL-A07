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
    public function setFormTambahAkunPenggunaSA_Pemerintah()
    {
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        return view('superadmin.V_FormTambahAkunPenggunaSA_Pemerintah', compact('villages', 'districts'));
    }
    public function SimpanTambahAkunPemerintah(Request $request)
    {

        $messages = [
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'],
            'street' => 'required',
            'village_id' => 'required',
            'password' => 'required|min:8',
            'username' => 'required|unique:users',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $Email = $request->input('email');
        $Username = $request->input('username');
        $PasswordUnhashed = $request->input('password');

        $roleId = 2;
        $user = User::postDataUser($Username, $PasswordUnhashed, $Email, $roleId);

        $userId = $user;
        $name = $request->input('name');
        $phone = $request->input('phone');
        $street = $request->input('street');
        $village_id = $request->input('village_id');
        Government::postDataGovernment($name, $phone, $street, $village_id, $userId);

        return redirect()->back()->with('success', 'Data Akun Pemerintah berhasil dibuat');
    }
}
