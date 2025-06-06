<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

class ProductController extends Controller
{
    /**
     * Display a listing of all products with their options.
     */
    public function index(Request $request)
    {
        $showUnavailable = $request->get('show_unavailable', false);
        
        $query = Product::active();
        
        if ($showUnavailable) {
            $query->with(['productOptions.productOptionValues']);
        } else {
            $query->with(['productOptions.availableValues']);
        }
        
        $products = $query->get();

        return response()->json($products);
    }

    /**
     * Display the specified product with all its options and values.
     */
    public function show($id, Request $request)
    {
        $showUnavailable = $request->get('show_unavailable', false);
        
        $query = Product::query();
        
        if ($showUnavailable) {
            $query->with(['productOptions.productOptionValues']);
        } else {
            $query->with(['productOptions.availableValues']);
        }
        
        $product = $query->findOrFail($id);

        return response()->json($product);
    }

    /**
     * Get all options for a specific product.
     */
    public function getProductOptions($productId, Request $request)
    {
        $showUnavailable = $request->get('show_unavailable', false);
        
        $product = Product::findOrFail($productId);
        
        if ($showUnavailable) {
            $options = $product->productOptions()->with('productOptionValues')->get();
        } else {
            $options = $product->productOptions()->with('availableValues')->get();
        }

        return response()->json([
            'product' => $product,
            'options' => $options
        ]);
    }

    /**
     * Get values for a specific product option.
     */
    public function getOptionValues($productId, $optionId)
    {
        $option = ProductOption::where('product_id', $productId)
            ->where('id', $optionId)
            ->with('productOptionValues')
            ->firstOrFail();

        return response()->json($option->productOptionValues);
    }

    /**
     * Example: Calculate total price with selected options.
     */
    public function calculatePrice(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $selectedOptions = $request->input('selected_options', []);
        
        $basePrice = $request->input('base_price', 0);
        $totalAdjustment = 0;

        foreach ($selectedOptions as $optionValueId) {
            $optionValue = ProductOptionValue::find($optionValueId);
            if ($optionValue) {
                $totalAdjustment += $optionValue->price_adjustment;
            }
        }

        return response()->json([
            'product' => $product->name,
            'base_price' => $basePrice,
            'price_adjustment' => $totalAdjustment,
            'total_price' => $basePrice + $totalAdjustment
        ]);
    }

    /**
     * Store a new product with options.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'stock' => 'integer|min:0',
            'sold' => 'integer|min:0',
            'ratings' => 'integer|min:0',
            'average_rating' => 'numeric|min:0|max:5',
            'is_active' => 'boolean',
            'options' => 'array',
            'options.*.option_name' => 'required|string',
            'options.*.display_name' => 'required|string',
            'options.*.is_required' => 'boolean',
            'options.*.values' => 'required|array',
            'options.*.values.*.value' => 'required|string',
            'options.*.values.*.display_value' => 'required|string',
            'options.*.values.*.price_adjustment' => 'numeric',
            'options.*.values.*.is_available' => 'boolean',
        ]);

        $product = Product::create($request->only([
            'name', 'category', 'image', 'description', 
            'stock', 'sold', 'ratings', 'average_rating', 'is_active'
        ]));

        if ($request->has('options')) {
            foreach ($request->options as $optionData) {
                $option = ProductOption::create([
                    'product_id' => $product->id,
                    'option_name' => $optionData['option_name'],
                    'display_name' => $optionData['display_name'],
                    'is_required' => $optionData['is_required'] ?? false,
                    'sort_order' => $optionData['sort_order'] ?? 0,
                ]);

                foreach ($optionData['values'] as $valueData) {
                    ProductOptionValue::create([
                        'product_option_id' => $option->id,
                        'value' => $valueData['value'],
                        'display_value' => $valueData['display_value'],
                        'price_adjustment' => $valueData['price_adjustment'] ?? 0,
                        'is_default' => $valueData['is_default'] ?? false,
                        'is_available' => $valueData['is_available'] ?? true,
                        'sort_order' => $valueData['sort_order'] ?? 0,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->load('productOptions.productOptionValues')
        ], 201);
    }
}
