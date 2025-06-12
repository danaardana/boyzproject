<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotAutoResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'response',
        'is_active',
        'priority',
        'additional_keywords',
        'match_type',
        'case_sensitive',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'additional_keywords' => 'array',
        'is_active' => 'boolean',
        'case_sensitive' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get the admin who created this auto response
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the admin who last updated this auto response
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /**
     * Scope for active auto responses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by priority
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc')->orderBy('created_at', 'asc');
    }

    /**
     * Check if a message matches this auto response
     */
    public function matches($message): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $keywords = array_merge([$this->keyword], $this->additional_keywords ?? []);
        
        foreach ($keywords as $keyword) {
            if ($this->matchesKeyword($message, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a message matches a specific keyword
     */
    private function matchesKeyword($message, $keyword): bool
    {
        $messageToCheck = $this->case_sensitive ? $message : strtolower($message);
        $keywordToCheck = $this->case_sensitive ? $keyword : strtolower($keyword);

        switch ($this->match_type) {
            case 'exact':
                return $messageToCheck === $keywordToCheck;
            case 'starts_with':
                return str_starts_with($messageToCheck, $keywordToCheck);
            case 'ends_with':
                return str_ends_with($messageToCheck, $keywordToCheck);
            case 'contains':
            default:
                return str_contains($messageToCheck, $keywordToCheck);
        }
    }

    /**
     * Get all keywords as a formatted string
     */
    public function getAllKeywordsString(): string
    {
        $keywords = array_merge([$this->keyword], $this->additional_keywords ?? []);
        return implode(', ', $keywords);
    }

    /**
     * Static method to find matching auto response for a message
     */
    public static function findMatchingResponse($message): ?self
    {
        return static::active()
            ->byPriority()
            ->get()
            ->first(function ($autoResponse) use ($message) {
                return $autoResponse->matches($message);
            });
    }
}
