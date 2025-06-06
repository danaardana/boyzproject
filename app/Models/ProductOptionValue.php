<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionValue extends Model
{
    protected $fillable = [
        'product_option_id',
        'value',
        'display_value',
        'price_adjustment',
        'is_default',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'is_default' => 'boolean',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the product option that owns the product option value.
     */
    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }

    /**
     * Get the product through the product option.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
                    ->through('productOption');
    }

    /**
     * Scope a query to only include default values.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope a query to only include available values.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Get formatted price adjustment.
     */
    public function getFormattedPriceAdjustmentAttribute()
    {
        if ($this->price_adjustment > 0) {
            return '+$' . number_format($this->price_adjustment, 2);
        } elseif ($this->price_adjustment < 0) {
            return '-$' . number_format(abs($this->price_adjustment), 2);
        }
        return '';
    }
}
