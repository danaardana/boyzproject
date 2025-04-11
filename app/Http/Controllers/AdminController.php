<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionContent;

class AdminController extends Controller
{
    public function landingPage()
    {        
        $sections = Section::where('is_active', true)->orderBy('show_order')->limit(10)->get();
        return view('landing.index', compact('sections'));
    }

    public function showTable($tableName)
    {
        // Validasi nama tabel jika diperlukan
        $validTables = ['admin', 'section', 'subsection'];
        if (!in_array($tableName, $validTables)) {
            abort(404); // Tampilkan halaman 404 jika tabel tidak valid
        }

        // Ambil data dari tabel sesuai dengan nama yang diberikan
        $data = DB::table($tableName)->get();

        // Kembalikan view dengan data yang diambil
        return view('tables.template', compact('data', 'tableName'));
    }

    public function landingPageTables()
    {
        $sections = Section::where('is_active', true)->orderBy('show_order')->get();
        return view('admin.landingpage_tables', compact('sections'));
    }
    

}