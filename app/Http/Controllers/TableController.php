<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Models\SectionContent;

class TableController extends Controller
{
    public function show($type = null){

        $exists = DB::table('sections')->where('name', $type)->exists();

        if ($exists || !$type)   {   
            $sections = Section::where('name', $type)->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
            return view('admin.'.$type, compact('sections', 'SectionContents', 'type'));
        } else {    
            $type = 'instagram';        
            return view('admin.'.$type, compact('type'));
        }
    }   
    
}
