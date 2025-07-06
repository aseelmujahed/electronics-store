<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryCompanyAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('delivery-company.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $deliveryEmail = 'deliverycompany@gmail.com';
        $deliveryPassword = 'deliverycompany';

        if (
            $request->email === $deliveryEmail &&
            $request->password === $deliveryPassword
        ) {
            session(['is_delivery_company' => true]);
            return redirect()->route('delivery-company.dashboard');
        } else {
            return back()->withErrors(['email' => __('Invalid credentials')]);
        }
    }

    public function logout()
    {
        session()->forget('is_delivery_company');
        return redirect()->route('delivery-company.login');
    }
}
