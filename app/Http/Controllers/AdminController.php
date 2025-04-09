<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionContent;

class AdminController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('show_order')->get();
        return view('admin.manage-sections', compact('sections'));
    }

    public function update(Request $request)
    {
        foreach ($request->sections as $id => $data) {
            Section::where('id', $id)->update([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'show_order' => $data['show_order'] ?? 0,
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'layout' => $data['layout'] ?? 1
            ]);
        }

        foreach ($request->contents as $id => $content) {
            SectionContent::where('id', $id)->update([
                'content_key' => $content['key'] ?? null,
                'content_value' => $content['value'] ?? null,
                'show_order' => $content['show_order'] ?? 0,
            ]);
        }

        return redirect()->route('admin.sections')->with('success', 'Sections updated successfully.');
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
}