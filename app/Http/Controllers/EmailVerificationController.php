<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $admin = \App\Models\Admin::where('email', $request->email)->first();
    
        if (!$admin) {
            return redirect('/')->with('error', 'Email tidak ditemukan.');
        }
    
        $admin->email_verified_at = now();
        $admin->save();
    
        return redirect('/')->with('success', 'Email berhasil diverifikasi.');
    }
    
}
