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
    public function login() //untuk menampilkan view login
    {
        return view("V_Login");
    }

    public function register() //untuk menampilkan view register
    {
        return view("V_Register");
    }

    public function authenticating(Request $request) //untuk memproses login
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]); //mengecek username dan password yang diinputkan oleh user (yang ini cek null / tidak null, karena kriteria nya 'required')

        if (Auth::attempt($credentials)) { // ini untuk cek kredensial login sesuai tidak dengan yang di database
            if (Auth::user()->status == 'inactive') { // perkondisian jika status user inactive
                return redirect('blocked'); // maka redirect ke route bernama blocked
            } else { // jika status user active
                if (Auth::user()->role_id == 1) { // cek role_id, jika role_id nya 1 (SuperAdmin)
                    return redirect('DashboardSA'); // redirect ke route DashboardSA
                }
                if (Auth::user()->role_id == 2) { // cek role_id, jika role_id nya 2 (Pemerintah)
                    return redirect('DashboardPemerintah'); // redirect ke route DashboardPemerintah
                }
                if (Auth::user()->role_id == 3) { // cek role_id, jika role_id nya 3 (Petani)
                    return redirect('HomepagePetani'); // redirect ke route HomepagePetani
                }
                if (Auth::user()->role_id == 4) { // cek role_id, jika role_id nya 4 (Kelompok Tani)
                    return redirect('HomepageKT'); // redirect ke route HomepageKT
                }
            }
        }
        Session::flash('status', 'failed'); // jika kredensial login tidak sesuai
        Session::flash('message', 'Username atau Password salah, silahkan ulangi kembali'); // set kirim atau show messagenya
        return redirect('login'); // kembali ke halaman login
    }

    public function logout(Request $request) //untuk logout
    {
        Auth::logout(); //Auth ini bawaan dari Laravel, untuk handle hal autentikasi. Sedangkan logout ini ya logout, keluar dari sistem
        $request->session()->invalidate(); //menghilangkan session
        $request->session()->regenerateToken(); //mengenerate token
        return redirect('login'); //kembali ke halaman login
    }
    public function blocked(Request $request) //untuk menampilkan view blocked (kurang lebih sama seperti logout, cuma ketambahan pesan akun dinonaktifkan saja)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('error', 'Akun anda sedang di nonaktifkan, silahkan hubungi admin');
    }

    public function showDistrictsandVillages() //untuk mengisi dropdown pemilihan kecamatan, desa, dan kelompok tani di halaman register
    {
        $districts = District::orderBy('name')->get(); //mengambil data kecamatan
        $villages = Village::orderBy('name')->get(); //mengambil data desa
        $lenders = Lender::orderBy('name')->get(); //mengambil data kelompok tani

        return view("V_Register", compact("districts", "villages", "lenders")); //mengembalikan ke halaman register
    }

    public function registerProcess(Request $request) //untuk proses register
    {
        $messages = [ // mengatur pesan error saat validasi
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

        $validated = $request->validate([ // validasi atau cek inputan user
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

        $request->password = Hash::make($request->password); //enkripsi password
        $user = User::create( //membuat user dengan inputan user berupa array/list berisi username, password, dan email
            [
                'username' => $validated['username'], 
                'password' => $validated['password'],
                'email' => $validated['email'],
            ]
        );
        Borrower::create( // membuat data petani baru dengan inputan user berupa array/list berisi name, phone, nik, street, land_area, village_id, user_id, dan lender_id
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
        Session::flash('status', 'success'); // menampilkan pesan success
        Session::flash('message', 'Registrasi berhasil, silahkan login.'); // set pesan ketika sukses register
        return redirect('login'); // kembali ke halaman login
    }

    public function forgotPassword() //untuk menampilkan halaman lupa password
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordProcess(Request $request) // untuk proses lupa password
    {
        $request->validate(['email' => 'required|email']); // validasi atau cek inputan user

        $status = Password::sendResetLink( // mengirim email berisi link untuk proses lupa password
            $request->only('email') // mengambil email
        );
        return $status === Password::RESET_LINK_SENT // jika email terkirim
            ? back()->with(['status' => __($status)]) // kembalikan ke halaman lupa password
            : back()->withErrors(['email' => __($status)]); // kembalikan ke halaman lupa password
    }

    public function resetPassword(string $token) //untuk menampilkan halaman reset password
    {
        return view('auth.reset-password', ['token' => $token]); // return ke halaman reset password dengan token lupa password
    }

    public function resetPasswordProcess(Request $request) //untuk proses reset password
    {
        $request->validate([ // validasi atau cek inputan user
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset( // proses reset password
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) { // fungsi reset password
                $user->forceFill([ // mengisi user
                    'password' => Hash::make($password) // enkripsi password
                ])->setRememberToken(Str::random(60)); // membuat token

                $user->save(); // menyimpan

                event(new PasswordReset($user)); // event password reset
            }
        );

        return $status === Password::PASSWORD_RESET // jika password terreset
            ? redirect()->route('login')->with('status', __($status)) // kembalikan ke halaman login
            : back()->withErrors(['email' => [__($status)]]); // kembalikan ke halaman reset password
    }
}
