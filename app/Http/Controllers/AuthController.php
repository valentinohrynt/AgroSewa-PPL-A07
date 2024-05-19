<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lender;
use App\Models\Village;
use App\Models\Borrower;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function login()
    {
        return view("V_Login");
    }

    public function register()
    {
        return view("V_Register");
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status == 'inactive') {
                return redirect('blocked');
            } else {
                if (Auth::user()->role_id == 1) {
                    return redirect('DashboardSA');
                }
                if (Auth::user()->role_id == 2) {
                    return redirect('DashboardPemerintah');
                }
                if (Auth::user()->role_id == 3) {
                    return redirect('HomepagePetani');
                }
                if (Auth::user()->role_id == 4) {
                    return redirect('HomepageKT');
                }
            }
        }
        Session::flash('status', 'failed');
        Session::flash('message', 'Username atau Password salah, silahkan ulangi kembali');
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
    public function blocked(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('error', 'Akun anda sedang di nonaktifkan, silahkan hubungi admin');
    }

    public function showDistrictsandVillages()
    {
        $districts = District::orderBy('name')->get();
        $villages = Village::orderBy('name')->get();
        $lenders = Lender::orderBy('name')->get();

        return view("V_Register", compact("districts", "villages", "lenders"));
    }

    public function registerProcess(Request $request)
    {

        $messages = [
            'password.required' => 'Kata Sandi harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'street.required' => 'Nama Jalan harus diisi.',
            'nik.required' => 'NIK harus diisi',
            'lender_id.required' => 'Nama Kelompok Tani harus diisi',
            'village_id.required' => 'Desa harus diisi',
            'land_area.required' => 'Luas tanah harus diisi',
            'land_area.numeric' => 'Luas tanah harus berupa angka',
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'email.required' => 'Email harus diisi',
            'nik.unique' => 'NIK sudah terdaftar, silahkan gunakan NIK lain',
            'username.unique' => 'Username sudah terdaftar, silahkan gunakan username lain',
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lain',
        ];

        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|unique:users|max:255',
            'nik' => 'required|unique:borrowers|max:255',
            'street' => 'required',
            'land_area' => 'required|numeric',
            'lender_id' => 'required',
            'village_id' => 'required',
        ], $messages);

        $request->password = Hash::make($request->password);
        $user = User::create(
            [
                'username' => $validated['username'],
                'password' => $validated['password'],
                'email' => $validated['email'],
            ]
        );
        Borrower::create(
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'nik' => $validated['nik'],
                'street' => $validated['street'],
                'land_area' => $validated['land_area'],
                'village_id' => $validated['village_id'],
                'user_id' => $user->id,
                'lender_id' => $validated['lender_id'],
            ]
        );
        Session::flash('status', 'success');
        Session::flash('message', 'Registrasi berhasil, silahkan login.');
        return redirect('login');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordProcess(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
