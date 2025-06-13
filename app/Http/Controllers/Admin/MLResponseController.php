<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MLResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class MLResponseController extends Controller
{
    /**
     * Get ML responses (AJAX)
     */
    public function index(Request $request): JsonResponse
    {
        $query = MLResponse::with(['creator', 'updater', 'autoResponse']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('intent_key', 'like', "%{$search}%")
                  ->orWhere('response', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'usage_count');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $responses = $query->paginate($perPage);

        return response()->json($responses);
    }

    /**
     * Store a new ML response
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'intent_key' => 'required|string|max:255|unique:ml_responses',
            'response' => 'required|string',
            'category' => 'required|string|in:main_intent,sub_intent',
            'is_active' => 'boolean',
            'metadata' => 'nullable|array',
            'auto_response_id' => 'nullable|exists:chatbot_auto_responses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = MLResponse::create([
                'intent_key' => $request->intent_key,
                'response' => $request->response,
                'category' => $request->category,
                'is_active' => $request->is_active ?? true,
                'metadata' => $request->metadata,
                'auto_response_id' => $request->auto_response_id,
                'created_by' => Auth::guard('admin')->id(),
                'updated_by' => Auth::guard('admin')->id()
            ]);

            // Clear response dictionary cache
            Cache::forget(config('ml.cache.response_dict_key'));

            $response->load(['creator', 'updater', 'autoResponse']);

            return response()->json([
                'success' => true,
                'message' => 'ML response created successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ML response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an ML response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'response' => 'required|string',
            'category' => 'required|string|in:main_intent,sub_intent',
            'is_active' => 'boolean',
            'metadata' => 'nullable|array',
            'auto_response_id' => 'nullable|exists:chatbot_auto_responses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = MLResponse::findOrFail($id);
            
            $response->update([
                'response' => $request->response,
                'category' => $request->category,
                'is_active' => $request->is_active,
                'metadata' => $request->metadata,
                'auto_response_id' => $request->auto_response_id,
                'updated_by' => Auth::guard('admin')->id()
            ]);

            // Clear response dictionary cache
            Cache::forget(config('ml.cache.response_dict_key'));

            $response->load(['creator', 'updater', 'autoResponse']);

            return response()->json([
                'success' => true,
                'message' => 'ML response updated successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ML response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an ML response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $response = MLResponse::findOrFail($id);
            $response->delete();

            // Clear response dictionary cache
            Cache::forget(config('ml.cache.response_dict_key'));

            return response()->json([
                'success' => true,
                'message' => 'ML response deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete ML response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle ML response status
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            $response = MLResponse::findOrFail($id);
            $response->update([
                'is_active' => !$response->is_active,
                'updated_by' => Auth::guard('admin')->id()
            ]);

            // Clear response dictionary cache
            Cache::forget(config('ml.cache.response_dict_key'));

            return response()->json([
                'success' => true,
                'message' => 'ML response status updated successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ML response status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import responses from predict_v2.py
     */
    public function importFromPredictV2(): JsonResponse
    {
        try {
            // Get the response dictionary from predict_v2.py
            $responseDict = [
                // Main intents (fallback responses)
                "harga" => "💰 **INFORMASI HARGA** | Silakan sebutkan produk spesifik untuk info harga detail. Kami ada berbagai pilihan harga dan paket khusus!",
                "stok_produk" => "📦 **CEK STOK PRODUK** | Sebutkan produk yang ingin dicek stocknya. Kami update stok real-time!",
                "kategori_lighting" => "💡 **KATEGORI LIGHTING** | Tersedia berbagai jenis lampu dan aksesori lighting untuk motor matic Anda!",
                "kategori_mounting_body" => "🏍️ **KATEGORI MOUNTING & BODY** | Tersedia mounting dan body kit berkualitas untuk motor matic!",
                
                // Harga sub-intents
                "harga_harga_produk" => "💰 **HARGA PRODUK SPESIFIK** | Harga mounting carbon: Rp 450.000-650.000, Body kit: Rp 800.000-1.200.000, Lampu LED: Rp 350.000-550.000, Projector: Rp 750.000-950.000. *Harga dapat berubah, konfirmasi via WhatsApp untuk harga terkini!",
                "harga_harga_promo" => "🎉 **PROMO & DISKON TERKINI** | Saat ini ada promo bundling mounting + lampu diskon 15%! Flash sale setiap Jumat jam 19:00. Member discount 10%. Follow IG @motorparts_bandung untuk update promo terbaru! 🔥",
                "harga_harga_grosir" => "🏪 **HARGA GROSIR & RESELLER** | Harga khusus reseller: diskon 20-30% untuk pembelian min 5 pcs. Sistem dropship tersedia. MOQ grosir: 10 pcs. Daftar jadi partner via WhatsApp untuk price list khusus! 💼",
                "harga_harga_ongkir" => "🚚 **BIAYA PENGIRIMAN** | Bandung-Cimahi: GRATIS ongkir! Luar kota: Rp 15.000-25.000. Same day delivery +Rp 10.000. COD gratis area Bandung. Express overnight +Rp 20.000. Cek ongkir eksak via WhatsApp! 📦",
                "harga_harga_instalasi" => "🔧 **BIAYA PEMASANGAN** | Jasa pasang mounting: Rp 50.000. Body kit install: Rp 100.000. Lampu setup: Rp 75.000. Home service +Rp 30.000. Weekend service normal rate. Paket install beli produk diskon 50%! ⚡",
                
                // Stok sub-intents  
                "stok_produk_stok_tersedia" => "✅ **PRODUK READY STOCK** | Sebagian besar item ready stock! Mounting carbon, LED headlamp, body kit populer tersedia. Update stok real-time cek WhatsApp. Fast moving items selalu kami stock! 📦",
                "stok_produk_stok_habis" => "⏳ **RESTOCK SCHEDULE** | Item sold out biasanya restock 2-3 hari kerja. Import item 1-2 minggu. Limited edition by request. Join waiting list untuk prioritas stock! Info restock via broadcast WhatsApp 📱",
                "stok_produk_stok_booking" => "📝 **BOOKING & PRE-ORDER** | Bisa booking stock dengan DP 30%. Pre-order item khusus tersedia. Waiting list gratis! Notification otomatis saat stock ready. Booking berlaku 7 hari! 🎯",
                
                // Additional contextual responses
                "motor_compatibility" => "🏍️ **KOMPATIBILITAS MOTOR** | Produk tersedia untuk motor matic populer. Sebutkan tipe motor spesifik untuk cek compatibility. Custom fitting tersedia untuk motor langka! Konsultasi gratis via WhatsApp 💬",
                "general_inquiry" => "❓ **BANTUAN UMUM** | Silakan tanyakan hal spesifik tentang produk, harga, stok, atau pemasangan. Tim customer service kami siap membantu! WhatsApp aktif 09:00-17:00 WIB 📞"
            ];

            $imported = 0;
            $updated = 0;

            foreach ($responseDict as $intentKey => $response) {
                $mlResponse = MLResponse::updateOrCreate(
                    ['intent_key' => $intentKey],
                    [
                        'response' => $response,
                        'category' => str_contains($intentKey, '_') ? 'sub_intent' : 'main_intent',
                        'is_active' => true,
                        'updated_by' => Auth::guard('admin')->id()
                    ]
                );

                if ($mlResponse->wasRecentlyCreated) {
                    $imported++;
                } else {
                    $updated++;
                }
            }

            // Clear response dictionary cache
            Cache::forget(config('ml.cache.response_dict_key'));

            return response()->json([
                'success' => true,
                'message' => "Successfully imported ML responses: {$imported} new, {$updated} updated",
                'data' => [
                    'imported' => $imported,
                    'updated' => $updated
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import ML responses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint: Get all active ML responses (for Python ML model)
     */
    public function apiIndex(Request $request)
    {
        $responses = \App\Models\MLResponse::where('is_active', 1)
            ->get(['intent_key', 'response', 'category']);
        return response()->json($responses);
    }
} 