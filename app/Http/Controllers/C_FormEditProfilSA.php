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
    public function setFormEditProfilSA()
    {
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        $user = Auth::user();
        $userId = $user->id;
        $superadmin = Superadmin::getDataSuperadminbyUserId($userId);
        return view('superadmin.V_FormEditProfilSA', compact('superadmin', 'user', 'villages', 'districts'));
    }
    public function EditProfilSA(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $superadmin = Superadmin::getDataSuperadminbyUserId($userId);

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Alamat Email harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'street.required' => 'Alamat harus diisi.',
            'village_id.required' => 'Desa harus diisi',
            'username.required' => 'Username harus diisi',
            'email.email' => 'Mohon masukkan alamat email yang valid!',
            'email.unique' => 'Mohon maaf, alamat email tersebut sudah digunakan. ',
            'phone.regex' => 'Mohon masukkan nomor telepon yang valid! ',
            'oldPassword.required' => 'Kata sandi lama wajib diisi.',
            'newPassword.min' => 'Kata sandi baru minimal berisi 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId),],
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'],
            'street' => 'required',
            'village_id' => 'required',
            'oldPassword' => 'required',
            'username' => 'required',
            'newPassword' => $request->filled('newPassword') ? 'min:8' : ''
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (Hash::check($request->input('oldPassword'), $user->password)) {
            // Update data akun superadmin
            $superadminId = $superadmin->id;
            $name = $request->input('name');
            $phone = $request->input('phone');
            $street = $request->input('street');
            $village_id = $request->input('village_id');
            Superadmin::putDataSuperadmin($superadminId, $name, $phone, $street, $village_id);
            // Update kredensial login superadmin
            if ($request->filled('newPassword') || $request->input('username') !== $user->username) {
                $newEmail = $request->input('email');
                $newUsername = $request->input('username');
                $newPassword = $request->input('newPassword');
                User::putDataUser($userId, $newUsername, $newPassword, $newEmail);
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan');
        } else {
            return redirect()->back()->with('error', 'Kata sandi lama Anda salah, silahkan coba lagi.');
        }
    }
}
