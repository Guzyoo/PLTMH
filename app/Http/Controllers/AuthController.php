<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan import Model User

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah Email terdaftar?
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika email tidak ditemukan di database
            return back()->withErrors(['login_error' => 'Akun tidak terdaftar di sistem kami.'])->onlyInput('email');
        }

        // 3. Cek Password / Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/devices');
        }

        // 4. Jika Email ada tapi Password salah
        return back()->withErrors(['login_error' => 'Email/Password Anda Salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
