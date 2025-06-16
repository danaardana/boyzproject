<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'icon',
        'color',
        'action_type',
        'action_id',
        'action_model',
        'user_id',
        'user_type',
        'user_name',
        'user_email',
        'metadata',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByActionType($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    public function scopeByUserType($query, $userType)
    {
        return $query->where('user_type', $userType);
    }

    // Mutators & Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i');
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    // Static helper methods
    public static function createNotification(array $data)
    {
        return self::create([
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'icon' => $data['icon'] ?? self::getDefaultIcon($data['type']),
            'color' => $data['color'] ?? self::getDefaultColor($data['type']),
            'action_type' => $data['action_type'] ?? 'general',
            'action_id' => $data['action_id'] ?? null,
            'action_model' => $data['action_model'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'user_type' => $data['user_type'] ?? 'system',
            'user_name' => $data['user_name'] ?? null,
            'user_email' => $data['user_email'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);
    }

    private static function getDefaultIcon($type)
    {
        $icons = [
            'create' => 'bx bx-plus-circle',
            'update' => 'bx bx-edit-alt',
            'delete' => 'bx bx-trash',
            'login' => 'bx bx-log-in',
            'logout' => 'bx bx-log-out',
            'upload' => 'bx bx-upload',
            'download' => 'bx bx-download',
            'view' => 'bx bx-show',
            'system' => 'bx bx-cog',
            'error' => 'bx bx-error',
            'warning' => 'bx bx-error-circle',
            'success' => 'bx bx-check-circle',
            'info' => 'bx bx-info-circle',
        ];

        return $icons[$type] ?? 'bx bx-bell';
    }

    private static function getDefaultColor($type)
    {
        $colors = [
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'login' => 'info',
            'logout' => 'secondary',
            'upload' => 'primary',
            'download' => 'info',
            'view' => 'primary',
            'system' => 'dark',
            'error' => 'danger',
            'warning' => 'warning',
            'success' => 'success',
            'info' => 'info',
        ];

        return $colors[$type] ?? 'primary';
    }

    public static function markAllAsRead()
    {
        return self::unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public static function getUnreadCount()
    {
        return self::unread()->count();
    }

    public static function getRecentNotifications($limit = 10)
    {
        return self::recent($limit)->get();
    }
}
