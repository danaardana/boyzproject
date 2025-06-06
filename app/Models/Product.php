<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'image',
        'description',
        'stock',
        'sold',
        'ratings',
        'average_rating',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stock' => 'integer',
        'sold' => 'integer',
        'ratings' => 'integer',
        'average_rating' => 'decimal:1',
    ];

    /**
     * Get the product options for the product.
     */
    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class)->orderBy('sort_order');
    }

    /**
     * Get all option values for this product through product options.
     */
    public function getAllOptionValues()
    {
        return $this->productOptions()->with('productOptionValues')->get();
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
