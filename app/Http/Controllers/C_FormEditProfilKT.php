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
    public function setFormEditProfilKT()
    {
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);
        return view('lenders.V_FormEditProfilKT', compact('lender', 'user', 'villages', 'districts'));
    }
    public function EditProfilKT(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $lender = Lender::getDataLenderbyUserId($userId);

        $messages = [
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

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'],
            'nik' => 'required|numeric',
            'street' => 'required',
            'oldPassword' => 'required',
            'username' => ['required', Rule::unique('users')->ignore($userId)],
            'newPassword' => $request->filled('newPassword') ? 'min:8' : ''
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (Hash::check($request->input('oldPassword'), $user->password)) {
            // Update data akun lender
            $lenderId = $lender->id;
            $phone = $request->input('phone');
            $street = $request->input('street');
            $village_id = $request->input('village_id');
            $nik = $request->input('nik');
            Lender::putDataLender($lenderId, $nik, $phone, $street, $village_id);
            if ($request->filled('newPassword') || $request->filled('email') || $request->input('username') !== $user->username) {
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
