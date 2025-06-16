<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload file

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::orderBy('order')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:sections,name',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'content' => 'nullable|string',
                'button_text' => 'nullable|string|max:255',
                'button_link' => 'nullable|url',
                'layout' => 'nullable|integer|min:1|max:3',
                'show_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'image' => 'nullable|image|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('section_images', 'public');
            }

            $section = Section::create([
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'layout' => $request->layout ?? 1,
                'show_order' => $request->show_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
                'image' => $imagePath,
            ]);

            // Check if it's an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Section created successfully',
                    'data' => $section
                ]);
            }

            return redirect()->route('admin.sections.index')->with('success', 'Section created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating section: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create section: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to create section')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Section $section)
    {
        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json($section);
        }
        
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:sections,name,' . $section->id,
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'content' => 'nullable|string',
                'button_text' => 'nullable|string|max:255',
                'button_link' => 'nullable|url',
                'layout' => 'nullable|integer|min:1|max:3',
                'show_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'image' => 'nullable|image|max:2048',
            ]);

            $imagePath = $section->image;
            if ($request->hasFile('image')) {
                if ($section->image && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }
                $imagePath = $request->file('image')->store('section_images', 'public');
            } elseif ($request->boolean('remove_image')) {
                if ($section->image && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }
                $imagePath = null;
            }

            $section->update([
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'layout' => $request->layout ?? 1,
                'show_order' => $request->show_order ?? 0,
                'is_active' => $request->boolean('is_active', false),
                'image' => $imagePath,
            ]);

            // Check if it's an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Section updated successfully',
                    'data' => $section->fresh()
                ]);
            }

            return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating section: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update section: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to update section')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Section $section)
    {
        try {
            if ($section->image && Storage::disk('public')->exists($section->image)) {
                Storage::disk('public')->delete($section->image);
            }
            $section->delete();

            // Check if it's an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Section deleted successfully'
                ]);
            }

            return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting section: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete section: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to delete section');
        }
    }
}