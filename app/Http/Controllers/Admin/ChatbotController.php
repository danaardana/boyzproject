<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotAutoResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChatbotController extends Controller
{
    /**
     * Display the chatbot management page
     */
    public function index(Request $request)
    {
        // Get initial data for server-side rendering
        $query = ChatbotAutoResponse::with(['creator', 'updater']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keyword', 'like', "%{$search}%")
                  ->orWhere('response', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'priority');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'priority') {
            $query->byPriority();
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $autoResponses = $query->paginate($perPage);

        // Keep search parameters in pagination links
        $autoResponses->appends($request->query());

        // Get statistics
        $stats = [
            'total' => ChatbotAutoResponse::count(),
            'active' => ChatbotAutoResponse::where('is_active', true)->count(),
            'inactive' => ChatbotAutoResponse::where('is_active', false)->count(),
            'high_priority' => ChatbotAutoResponse::where('priority', '>=', 100)->count(),
        ];

        return view('admin.chatbot', compact('autoResponses', 'stats'));
    }

    /**
     * Get chatbot statistics (AJAX)
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total' => ChatbotAutoResponse::count(),
                'active' => ChatbotAutoResponse::where('is_active', true)->count(),
                'inactive' => ChatbotAutoResponse::where('is_active', false)->count(),
                'high_priority' => ChatbotAutoResponse::where('priority', '>=', 100)->count(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get stats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all auto responses (AJAX)
     */
    public function getAutoResponses(Request $request): JsonResponse
    {
        $query = ChatbotAutoResponse::with(['creator', 'updater']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keyword', 'like', "%{$search}%")
                  ->orWhere('response', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'priority');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'priority') {
            $query->byPriority();
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $autoResponses = $query->paginate($perPage);

        return response()->json($autoResponses);
    }

    /**
     * Store a new auto response
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|max:255',
            'response' => 'required|string',
            'priority' => 'integer|min:0|max:999',
            'additional_keywords' => 'array',
            'additional_keywords.*' => 'string|max:255',
            'match_type' => ['required', Rule::in(['exact', 'contains', 'starts_with', 'ends_with'])],
            'case_sensitive' => 'boolean',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $autoResponse = ChatbotAutoResponse::create([
                'keyword' => $request->keyword,
                'response' => $request->response,
                'priority' => $request->priority ?? 0,
                'additional_keywords' => $request->additional_keywords ?? [],
                'match_type' => $request->match_type,
                'case_sensitive' => $request->case_sensitive ?? false,
                'description' => $request->description,
                'is_active' => $request->is_active ?? true,
                'created_by' => Auth::guard('admin')->id(),
                'updated_by' => Auth::guard('admin')->id(),
            ]);

            $autoResponse->load(['creator', 'updater']);

            return response()->json([
                'success' => true,
                'message' => 'Auto response created successfully',
                'data' => $autoResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create auto response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific auto response
     */
    public function show($id): JsonResponse
    {
        try {
            $autoResponse = ChatbotAutoResponse::with(['creator', 'updater'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $autoResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Auto response not found'
            ], 404);
        }
    }

    /**
     * Update an auto response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|max:255',
            'response' => 'required|string',
            'priority' => 'integer|min:0|max:999',
            'additional_keywords' => 'array',
            'additional_keywords.*' => 'string|max:255',
            'match_type' => ['required', Rule::in(['exact', 'contains', 'starts_with', 'ends_with'])],
            'case_sensitive' => 'boolean',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $autoResponse = ChatbotAutoResponse::findOrFail($id);
            
            $autoResponse->update([
                'keyword' => $request->keyword,
                'response' => $request->response,
                'priority' => $request->priority ?? 0,
                'additional_keywords' => $request->additional_keywords ?? [],
                'match_type' => $request->match_type,
                'case_sensitive' => $request->case_sensitive ?? false,
                'description' => $request->description,
                'is_active' => $request->is_active ?? true,
                'updated_by' => Auth::guard('admin')->id(),
            ]);

            $autoResponse->load(['creator', 'updater']);

            return response()->json([
                'success' => true,
                'message' => 'Auto response updated successfully',
                'data' => $autoResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update auto response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an auto response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $autoResponse = ChatbotAutoResponse::findOrFail($id);
            $autoResponse->delete();

            return response()->json([
                'success' => true,
                'message' => 'Auto response deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete auto response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle auto response status
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            $autoResponse = ChatbotAutoResponse::findOrFail($id);
            $autoResponse->update([
                'is_active' => !$autoResponse->is_active,
                'updated_by' => Auth::guard('admin')->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => $autoResponse->is_active ? 'Auto response activated' : 'Auto response deactivated',
                'data' => $autoResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test auto response matching
     */
    public function testResponse(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $matchingResponse = ChatbotAutoResponse::findMatchingResponse($request->message);

            if ($matchingResponse) {
                return response()->json([
                    'success' => true,
                    'matched' => true,
                    'response' => $matchingResponse->response,
                    'auto_response' => $matchingResponse
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'matched' => false,
                    'message' => 'No matching auto response found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to test response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete auto responses
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:chatbot_auto_responses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $deletedCount = ChatbotAutoResponse::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} auto response(s)"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete auto responses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export auto responses
     */
    public function export(): JsonResponse
    {
        try {
            $autoResponses = ChatbotAutoResponse::with(['creator', 'updater'])
                ->orderBy('priority', 'desc')
                ->get()
                ->map(function ($response) {
                    return [
                        'id' => $response->id,
                        'keyword' => $response->keyword,
                        'response' => $response->response,
                        'additional_keywords' => implode(', ', $response->additional_keywords ?? []),
                        'match_type' => $response->match_type,
                        'case_sensitive' => $response->case_sensitive ? 'Yes' : 'No',
                        'priority' => $response->priority,
                        'status' => $response->is_active ? 'Active' : 'Inactive',
                        'description' => $response->description,
                        'created_by' => $response->creator->name ?? 'Unknown',
                        'created_at' => $response->created_at->format('Y-m-d H:i:s'),
                        'updated_by' => $response->updater->name ?? 'Unknown',
                        'updated_at' => $response->updated_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $autoResponses,
                'filename' => 'chatbot_auto_responses_' . date('Y-m-d_H-i-s') . '.csv'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export auto responses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get auto response for a message (Public API for chat bubble)
     */
    public function getAutoResponse(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'matched' => false,
                'message' => 'Invalid message'
            ], 422);
        }

        try {
            $matchingResponse = ChatbotAutoResponse::findMatchingResponse($request->message);

            if ($matchingResponse) {
                return response()->json([
                    'success' => true,
                    'matched' => true,
                    'response' => $matchingResponse->response,
                    'auto_response_id' => $matchingResponse->id,
                    'keyword' => $matchingResponse->keyword,
                    'match_type' => $matchingResponse->match_type
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'matched' => false,
                    'message' => 'No matching auto response found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'matched' => false,
                'message' => 'Error processing request: ' . $e->getMessage()
            ], 500);
        }
    }
}
