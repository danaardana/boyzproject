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
        'is_important',
        'is_deleted',
        'deleted_at',
        'last_update_time'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_important' => 'boolean',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'last_update_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted() {
        static::creating(function ($model) {
            if (empty($model->content_key)) {
                $model->content_key = "default";
            }
        });
    }

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

    /**
     * Get user-friendly category display name
     */
    public function getCategoryDisplayName()
    {
        return match($this->category) {
            self::CATEGORY_WARRANTY => 'Warranty',
            self::CATEGORY_INSTALLATION => 'Installation',
            self::CATEGORY_SUPPORT => 'Support',
            self::CATEGORY_GENERAL => 'General',
            default => ucfirst($this->category)
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

    public function markAsImportant()
    {
        $this->is_important = true;
        $this->save();
    }

    public function markAsUnimportant()
    {
        $this->is_important = false;
        $this->save();
    }

    public function toggleImportant()
    {
        $this->is_important = !$this->is_important;
        $this->save();
        return $this->is_important;
    }

    public function moveToTrash()
    {
        $this->is_deleted = true;
        $this->deleted_at = now();
        $this->save();
    }

    public function restoreFromTrash()
    {
        $this->is_deleted = false;
        $this->deleted_at = null;
        $this->save();
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeTrashed($query)
    {
        return $query->where('is_deleted', true);
    }
} 