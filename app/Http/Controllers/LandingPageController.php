<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class LandingPageController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)->orderBy('show_order')->limit(10)->get();
        return view('landing.index', compact('sections'));
        #return view('landing.sections.' . $section->layout, compact('section', 'contents'));
    }    
    
    public function showLoginForm()
    {
        return view('landing.login'); // Pastikan path ini sesuai dengan struktur folder Anda
    }
}
