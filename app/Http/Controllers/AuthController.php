<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // jika sudah login, maka redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            
            \Log::info('Login', ['username' => $request->username]);
            if (Auth::attempt($credentials)) {
                \Log::info('Login Berhasil', ['username' => $request->username]);
    
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            } else {
                \Log::info('Login Gagal', ['username' => $request->username]);
    
                return response()->json([
                    'status' => false,
                    'message' => 'Login Gagal',
                    'msgField' => [
                        'username' => ['Username atau password salah'],
                        'password' => ['Username atau password salah']
                    ]
                ]);
                
            }
        }
    
        return redirect('login');
    }
    

    public function logout(Request $request)
{
    \Log::info('Memanggil logout...');

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    \Log::info('Berhasil logout dan invalidasi session.');

    return redirect('login');
}

}
