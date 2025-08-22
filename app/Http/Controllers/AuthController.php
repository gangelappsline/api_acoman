<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()) {
            // Redirigir al usuario a su dashboard según su rol
            switch (auth()->user()->role) {
                case 'administrador':
                    return redirect('/administrador/dashboard');
                case 'cliente':
                    return redirect('/cliente/maniobras');
                case 'caseta':
                    return redirect('/caseta/programacion');
                default:
                    return redirect()->route('dashboard.index');
            }
        }
        return view('auth.login');
    }
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            switch (auth()->user()->role) {
                case 'administrador':
                    return redirect()->intended('administrador/dashboard');
                case 'cliente':
                    return redirect()->intended('cliente/dashboard');
                    break;
                case 'caseta':
                    return redirect()->intended('caseta/programacion');
                    break;
                default:
                    return redirect()->intended('admin/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
