<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_name',
        'display_name',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the product that owns the product option.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the option values for the product option.
     */
    public function productOptionValues(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class)->orderBy('sort_order');
    }

    /**
     * Get only available option values for the product option.
     */
    public function availableValues(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class)->available()->orderBy('sort_order');
    }

    /**
     * Get the default option value.
     */
    public function defaultValue(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class)->where('is_default', true);
    }

    /**
     * Scope a query to only include required options.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}
