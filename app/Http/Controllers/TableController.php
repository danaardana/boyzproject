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

        if ($exists || !$type) {   
            $sections = Section::where('name', $type)->get();
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
    
            if ($type == 'portofolio') {
                $allCategories =  [];
                foreach ($SectionContents as $content) {
                    $extraData = json_decode($content->extra_data);
                    if ($extraData && property_exists($extraData, 'categories')) {
                        $cats = is_string($extraData->categories) ? explode(',', $extraData->categories) : (array)$extraData->categories;
                        $allCategories = array_merge($allCategories, array_map('trim', $cats));
                    }
                }
                $allCategories = array_unique($allCategories);
                return view('admin.data', compact('sections', 'SectionContents', 'type', 'allCategories'));
            } else {
                return view('admin.data', compact('sections', 'SectionContents', 'type'));
            }
            
        } else {    
            $type = 'Error';        
            return view('admin.data', compact('type'));
        }
    }   
    
}
