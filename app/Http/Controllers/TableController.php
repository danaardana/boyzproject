<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Section;
use App\Models\SectionContent;
use Illuminate\Support\Str;
use App\Traits\NotificationHelper;

class TableController extends Controller
{
    use NotificationHelper;
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

    /**
     * Store a new section content
     */
    public function store(Request $request)
    {
        try {
            // Get section by type
            $section = Section::where('name', $request->type)->first();
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Section not found'
                ], 404);
            }

            // Validate based on content type
            $rules = $this->getValidationRules($request->type, true);
            $request->validate($rules);

            // Prepare extra data based on type
            $extraData = $this->prepareExtraData($request);

            // Handle file upload if exists
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('section_images', 'public');
                $extraData['image'] = $imagePath;
            }

            // Create section content
            $sectionContent = SectionContent::create([
                'section_id' => $section->id,
                'content_key' => $request->content_key ?? $request->Title ?? 'Default Title',
                'content_value' => $request->content_value ?? $request->embed_url ?? '',
                'description' => $request->description ?? '',
                'type' => $request->type,
                'extra_data' => json_encode($extraData),
                'show_order' => $request->show_order ?? 0,
            ]);

            // Create notification
            $this->notifyCreated('section_content', $sectionContent, [
                'section_type' => $request->type,
                'content_title' => $sectionContent->content_key
            ]);

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' item created successfully',
                'data' => $sectionContent
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating section content: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get section content for editing
     */
    public function edit($id)
    {
        try {
            $sectionContent = SectionContent::with('section')->findOrFail($id);
            $extraData = json_decode($sectionContent->extra_data, true);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $sectionContent->id,
                    'section_name' => $sectionContent->section->name ?? '',
                    'content_key' => $sectionContent->content_key,
                    'content_value' => $sectionContent->content_value,
                    'description' => $sectionContent->description ?? '',
                    'show_order' => $sectionContent->show_order,
                    'type' => $sectionContent->type,
                    'extra_data' => $extraData
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load item data'
            ], 500);
        }
    }

    /**
     * Update section content
     */
    public function update(Request $request, $id)
    {
        try {
            $sectionContent = SectionContent::findOrFail($id);
            
            // Validate based on content type
            $rules = $this->getValidationRules($sectionContent->type, false);
            $request->validate($rules);

            // Prepare extra data
            $extraData = json_decode($sectionContent->extra_data, true) ?? [];
            $newExtraData = $this->prepareExtraData($request);
            $extraData = array_merge($extraData, $newExtraData);

            // Handle file upload if exists
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if (isset($extraData['image']) && $extraData['image']) {
                    Storage::disk('public')->delete($extraData['image']);
                }
                $imagePath = $request->file('image')->store('section_images', 'public');
                $extraData['image'] = $imagePath;
            }

            // Update section content
            $sectionContent->update([
                'content_key' => $request->content_key ?? $request->Title ?? $sectionContent->content_key,
                'content_value' => $request->content_value ?? $request->embed_url ?? $sectionContent->content_value,
                'description' => $request->description ?? $sectionContent->description,
                'extra_data' => json_encode($extraData),
                'show_order' => $request->show_order ?? $sectionContent->show_order,
            ]);

            // Create notification
            $this->notifyUpdated('section_content', $sectionContent, [
                'section_type' => $sectionContent->type,
                'content_title' => $sectionContent->content_key
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'data' => $sectionContent
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating section content: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete section content
     */
    public function destroy($id)
    {
        try {
            $sectionContent = SectionContent::findOrFail($id);
            
            // Store data for notification before deletion
            $itemName = $sectionContent->content_key;
            $sectionType = $sectionContent->type;
            
            // Delete associated image if exists
            $extraData = json_decode($sectionContent->extra_data, true);
            if (isset($extraData['image']) && $extraData['image']) {
                Storage::disk('public')->delete($extraData['image']);
            }

            $sectionContent->delete();

            // Create notification
            $this->notifyDeleted('section_content', null, [
                'item_name' => $itemName,
                'section_type' => $sectionType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting section content: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules based on content type
     */
    private function getValidationRules($type, $isCreate = true)
    {
        $baseRules = [
            'show_order' => 'nullable|integer|min:0',
        ];

        switch ($type) {
            case 'categories':
                return array_merge($baseRules, [
                    'Title' => 'required|string|max:255',
                    'link' => 'nullable|url',
                    'image' => $isCreate ? 'required|image|max:2048' : 'nullable|image|max:2048',
                ]);

            case 'instagram':
                return array_merge($baseRules, [
                    'content_key' => 'required|string|max:255',
                    'embed_url' => 'required|url',
                ]);

            case 'portofolio':
                return array_merge($baseRules, [
                    'content_key' => 'required|string|max:255',
                    'content_value' => 'required|string',
                    'categories' => 'required|array',
                    'link' => 'nullable|url',
                    'image' => $isCreate ? 'required|image|max:2048' : 'nullable|image|max:2048',
                ]);

            case 'testimonials':
                return array_merge($baseRules, [
                    'content_key' => 'required|string|max:255',
                    'content_value' => 'required|string',
                    'image' => 'nullable|image|max:2048',
                ]);

            case 'tiktok':
                return array_merge($baseRules, [
                    'content_key' => 'required|string|max:255',
                    'embed_url' => 'required|url',
                    'video_id' => 'nullable|string',
                ]);

            case 'promotion':
                return array_merge($baseRules, [
                    'content_key' => 'required|string|max:255',
                    'content_value' => 'required|string',
                    'image' => 'nullable|image|max:2048',
                ]);

            default:
                return $baseRules;
        }
    }

    /**
     * Prepare extra data based on request
     */
    private function prepareExtraData(Request $request)
    {
        $extraData = [];

        // Common fields
        if ($request->has('link')) {
            $extraData['link'] = $request->link;
        }

        // Type-specific fields
        switch ($request->type) {
            case 'instagram':
            case 'tiktok':
                if ($request->has('embed_url')) {
                    $extraData['embed_url'] = $request->embed_url;
                }
                if ($request->has('video_id')) {
                    $extraData['video_id'] = $request->video_id;
                }
                break;

            case 'portofolio':
                if ($request->has('categories')) {
                    $extraData['categories'] = is_array($request->categories) 
                        ? implode(', ', $request->categories) 
                        : $request->categories;
                }
                break;
        }

        return $extraData;
    }
}
