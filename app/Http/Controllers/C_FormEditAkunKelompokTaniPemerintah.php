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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class C_FormEditAkunKelompokTaniPemerintah extends Controller
{
    public function setFormEditAkunKelompokTaniPemerintah($lender_id)
    {
        $lenderId = Crypt::decrypt($lender_id);
        $lender = Lender::getDataLenderbyId($lenderId);
        $lender_userId = $lender->user_id;
        $user = User::getDataUserbyId($lender_userId);
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        return view('government.V_FormEditAkunKelompokTaniPemerintah', compact('lender', 'user', 'villages', 'districts'));
    }

    public function SimpanEditAkunKelompokTani(Request $request, $lender_id)
    {
        $lenderId = Crypt::decrypt($lender_id);
        $lender = Lender::getDataLenderbyId($lenderId);
        $lender_userId = $lender->user_id;
        $user = User::getDataUserbyId($lender_userId);
        $signedUser = Auth::user();
        $messages = [
            'email.required' => 'Alamat Email harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'street.required' => 'Alamat harus diisi.',
            'village_id.required' => 'Desa harus diisi',
            'username.required' => 'Username harus diisi',
            'email.email' => 'Mohon masukkan alamat email yang valid!',
            'email.unique' => 'Mohon maaf, alamat email tersebut sudah digunakan. ',
            'phone.regex' => 'Mohon masukkan nomor telepon yang valid! ',
            'governmentPassword.required' => 'Kata sandi anda harus diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('users')->ignore($lender_userId),],
            'phone' => ['required', 'regex:/^(\+62|0)\d{9,12}$/'],
            'street' => 'required',
            'village_id' => 'required',
            'password' => $request->filled('password') ? 'min:8' : '',
            'governmentPassword' => 'required',
            'username' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (Hash::check($request->input('governmentPassword'), $signedUser->password)) {
            $phone = $request->input('phone');
            $street = $request->input('street');
            $village_id = $request->input('village_id');
            Lender::putDataLender($lenderId, $phone, $street, $village_id);
            if ($request->filled('password') || $request->input('username') !== $user->username) {
                $newEmail = $request->input('email');
                $newUsername = $request->input('username');
                $newPassword = $request->input('newPassword');
                User::putDataUser($lender_userId, $newUsername, $newPassword, $newEmail);
            }
            return redirect()->back()->with('success', 'Sukses, perubahan data akun berhasil disimpan');
        } else {
            return redirect()->back()->with('error', 'Kata sandi Anda salah, silahkan coba lagi.');
        }
    }
}
