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

}
