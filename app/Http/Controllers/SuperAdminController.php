<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function loginForm()
    {
        return view('superadmin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $superAdminEmail = 'superadmin@gmail.com';
        $superAdminPassword = 'superadmin';

        if (
            $request->email === $superAdminEmail &&
            $request->password === $superAdminPassword
        ) {
            session(['is_super_admin' => true]);
            return redirect()->route('superadmin.dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        session()->forget('is_super_admin');
        return redirect()->route('superadmin.login.form');
    }
}
