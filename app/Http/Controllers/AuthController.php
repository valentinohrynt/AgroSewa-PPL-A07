<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        return view("login");
    }
    public function loginp(){
        return view("loginp");
    }
    public function register(){
        return view("register");
    }
    public function authenticating(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            if (Auth::user()->is_active != 'yes') {
                if (auth()->user()->role_id == 3) {
                    Session::flash('status', 'failed');
                    Session::flash('message', 'Akun belum diaktivasi. Segera kontak admin');
                    return redirect('/login');
                }else{
                    return redirect('/loginp');  
                }
            }
            return redirect('homepage');
            // return redirect()->intended('dashboard');
        }
        Session::flash('status', 'failed');
        Session::flash('message', 'Username atau Password salah, silahkan ulangi kembali');
        return redirect('/login');
    }
    public function authenticating_admin(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            if (Auth::user()->is_active != 'yes') {
                Session::flash('status', 'failed');
                Session::flash('message', 'Akun belum diaktivasi. Segera kontak admin');
                return redirect('/loginp');
            }

            if (Auth::user()->role_id == 1) {
                return redirect('dashboard-admin');
            }

            if (Auth::user()->role_id == 2) {
                return redirect('dashboard-pemerintah');
            }

            if (Auth::user()->role_id == 4) {
                return redirect('dashboard-poktan');
            }
            // return redirect()->intended('dashboard');

        }

        Session::flash('status', 'failed');
        Session::flash('message', 'Username atau Password salah, silahkan ulangi kembali');
        return redirect('/loginp');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
