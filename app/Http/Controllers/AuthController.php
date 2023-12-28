<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return redirect()->back()->withInput($request->except('password'))->with('error', 'Invalid credentials');
        }

        return redirect()->route('dashboard');
    }
}
