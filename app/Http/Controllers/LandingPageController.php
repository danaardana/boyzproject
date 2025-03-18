<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingSection;

class LandingPageController extends Controller
{
    public function index()
    {
        $sections = LandingSection::where('is_active', true)->orderBy('order')->limit(10)->get();
        return view('landing.index', compact('sections'));
    }    

    public function edit()
    {
        $sections = LandingSection::all();
        return view('admin.manage-landing', compact('sections'));
    }

    public function update(Request $request)
    {
        foreach ($request->sections as $id => $content) {
            LandingSection::where('id', $id)->update([
                'content' => $content,
                'is_active' => isset($request->is_active[$id]) ? 1 : 0
            ]);
        }
        return redirect()->route('admin.manage-landing')->with('success', 'Landing page updated.');
    }
}

