<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    use HasFactory;

    // Status Constants
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    // Category Constants
    const CATEGORY_WARRANTY = 'warranty';
    const CATEGORY_INSTALLATION = 'installation';
    const CATEGORY_SUPPORT = 'support';
    const CATEGORY_GENERAL = 'general';

    protected $fillable = [
        'customer_id',
        'admin_id',
        'content_key',
        'content',
        'status',
        'category',
        'is_read',
        'last_update_time'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'last_update_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the responses for this message.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(MessageResponse::class)->orderBy('created_at', 'asc');
    }

    public function isUnassigned()
    {
        return is_null($this->admin_id);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_NEW => 'bg-primary',
            self::STATUS_IN_PROGRESS => 'bg-warning',
            self::STATUS_RESOLVED => 'bg-success',
            self::STATUS_CLOSED => 'bg-secondary',
            default => 'bg-info'
        };
    }

    public function getCategoryBadgeClass()
    {
        return match($this->category) {
            self::CATEGORY_WARRANTY => 'bg-info',
            self::CATEGORY_INSTALLATION => 'bg-warning',
            self::CATEGORY_SUPPORT => 'bg-primary',
            self::CATEGORY_GENERAL => 'bg-secondary',
            default => 'bg-info'
        };
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->save();
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
} 