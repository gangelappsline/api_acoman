<?php

namespace App\Http\Controllers\Toll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'caseta') {
            // User is authenticated and has the 'toll' role
            return redirect('/caseta/programacion');
        } else {
            return view('toll.login');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'code' => 'required|string|digits:6'
        ]);

        $user = \App\Models\User::where('code', $request->code)
            ->where('role', 'caseta')
            ->first();

        if ($user) {
            Auth::login($user);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
