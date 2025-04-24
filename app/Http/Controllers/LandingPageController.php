<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class LandingPageController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)->orderBy('show_order')->get();
        return view('landing.index', compact('sections'));
    }    
    
    public function showLoginForm()
    {
        return view('landing.login'); 
    }

    public function login(Request $request)
    {
    $credentials = $request->only('email', 'password');

    //if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->intended(route('admin.dashboard'));
    //}

    return back()->withErrors(['email' => 'Email atau password salah.']);
    }

}
