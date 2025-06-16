<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)->orderBy('show_order')->get();
        return view('landing.index', compact('sections'));
    }
    
    public function privacy()
    {
        return view('landing.privacy');
    }
    
    public function terms()
    {
        return view('landing.terms');
    }

     public function create()
    {
        return view('admin.landing_pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (LandingPage::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        LandingPage::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page created successfully.');
    }

    public function show(LandingPage $landingPage)
    {
        return view('admin.landing_pages.show', compact('landingPage'));
    }

    public function edit(LandingPage $landingPage)
    {
        return view('admin.landing_pages.edit', compact('landingPage'));
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $slug = Str::slug($request->title);
        if ($slug !== $landingPage->slug) {
            $originalSlug = $slug;
            $count = 1;
            while (LandingPage::where('slug', $slug)->where('id', '!=', $landingPage->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }


        $landingPage->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page updated successfully.');
    }

     public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();
        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page deleted successfully.');
    }
}
