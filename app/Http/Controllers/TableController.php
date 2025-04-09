<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionContent;

class TableController extends Controller
{
    public function show(Request $request)
    {
        $type = $request->query('type');

        $sections = Section::all();
        $SectionContents = SectionContent::all();

        if ($type === 'testimonials') {    
            $sections = Section::where('name', 'testimonials')->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        } elseif ($type === 'instagram') {
            $sections = Section::where('name', 'instagram')->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        } elseif ($type === 'tiktok') {
            $sections = Section::where('name', 'tikTok')->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        } elseif ($type === 'portofolio') {
            $sections = Section::where('name', 'portofolio')->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        }

        return view('admin.tables', compact('sections', 'SectionContents', 'type'));
    }
}
