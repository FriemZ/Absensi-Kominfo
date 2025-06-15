<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'], // ini bisa username atau name
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Coba cari user berdasarkan username atau name
        $user = \App\Models\User::where('username', $login)
            ->orWhere('name', $login)
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            Auth::login($user, $remember);

            $request->session()->regenerate();

            if ($user->role === 'super_admin' || $user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'honorer') {
                return redirect()->intended('/home');
            } else {
                Auth::logout();
                throw ValidationException::withMessages([
                    'login' => 'Role tidak valid.',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'login' => 'Username/Name atau password salah.',
        ]);
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
