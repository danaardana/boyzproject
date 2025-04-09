<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Bypass verifikasi database dan langsung otentikasi
        Auth::guard('admin')->loginUsingId(1); // Anggap ID 1 adalah admin

        // Redirect ke dashboard admin
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}


