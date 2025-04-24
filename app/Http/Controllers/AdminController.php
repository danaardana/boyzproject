<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionContent;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        Auth::guard('admin')->loginUsingId(1); 

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function landingPage()
    {        
        $sections = Section::where('is_active', true)
        ->orderBy('show_order')
        ->limit(10)
        ->get();
        return view('landing.index', compact('sections'));
    }

    public function showTable($tableName)
    {
        $validTables = ['admin', 'section', 'subsection'];
        if (!in_array($tableName, $validTables)) {
            abort(404);
        }

        $data = DB::table($tableName)->get();
        return view('tables.template', compact('data', 'tableName'));
    }

    public function landingPageTables()
    {
        $sections = Section::where('is_active', true)
        ->orderBy('show_order')
        ->get();
        return view('admin.landingpage_tables', compact('sections'));
    }
       
    public function subsectionTables($id = null)
    {
        $sectionName = null;
        if ($id) {
            $section = Section::find($id);
            $sectionName = $section ? $section->name : 'Section Not Found';
        }
    
        $sections = SectionContent::join('sections', 'section_contents.section_id', '=', 'sections.id')
            ->select('section_contents.*', 'sections.name as section_name')
            ->when($id, function ($query) use ($id) {
                return $query->where('section_contents.section_id', $id);
            })
            ->get();
    
        return view('admin.subsection_tables', compact('sections', 'sectionName'));
        
    }
    
    public function createOrEditForm(Request $request)
    {
        $type = 'section'; // Ganti dengan nilai dinamis sesuai kebutuhan
    
        // Ambil ID dari section berdasarkan kolom name
        $section = Section::where('name', $type)->first();
        
        if ($section) {
            // Jika ada, ambil konten terkait (jika ada)
            $subsection = SectionContent::where('section_id', $section->id)->first(); 
            return view('admin.subsection_form', compact('subsection'));
        }
    
        return view('admin.subsection_form'); // Jika tidak ditemukan, tampilkan form kosong
    }

    public function update(Request $request, $id)
    {
        // Ambil parameter query "type"
        $type = $request->query('type');
    
        // Temukan section content berdasarkan ID
        $sectionContent = SectionContent::findOrFail($id);
        
        if ($type == 'instagram') {
            // Validasi inputan jika tipe adalah instagram
            $request->validate([
                'show_order' => 'required|integer',
                'content_key' => 'required|string|max:255',
                'embed_url' => 'nullable|url',
            ]);
    
            // Update data section content berdasarkan ID
            $sectionContent->update([
                'show_order' => $request->input('show_order'),
                'content_key' => $request->input('content_key'),
               'embed_url'=> request()->get("embed_url"), 
           ]);
            
           return redirect()->route('admin.tables', ['type'=>'instagram'])->with('success', "Data berhasil diperbarui!");
       }
    
       return redirect()->route('admin.tables')->withErrors(['error_message'=>'Invalid Type']);
    }
    
    public function faqPage()
    {        
        return view('admin.faq');
    }    
        
    public function adminPage()
    {        
        return view('admin.admin');
    }

    public function chatPage()
    {        
        return view('admin.chat');
    }




    

}