<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MLResponse extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ml_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'intent_key',
        'response',
        'category',
        'is_active',
        'usage_count',
        'metadata',
        'auto_response_id',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer',
        'metadata' => 'json'
    ];

    /**
     * Get the associated auto response
     */
    public function autoResponse(): BelongsTo
    {
        return $this->belongsTo(ChatbotAutoResponse::class, 'auto_response_id');
    }

    /**
     * Get the admin who created this response
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the admin who last updated this response
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /**
     * Scope for active responses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for main intents
     */
    public function scopeMainIntents($query)
    {
        return $query->where('category', 'main_intent');
    }

    /**
     * Scope for sub intents
     */
    public function scopeSubIntents($query)
    {
        return $query->where('category', 'sub_intent');
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Get all responses as a dictionary for ML model
     */
    public static function getResponseDictionary()
    {
        return static::active()
            ->get()
            ->pluck('response', 'intent_key')
            ->toArray();
    }
} 