<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    use HasFactory;

    // Status Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    // Priority Constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    protected $fillable = [
        'customer_id',
        'admin_id',
        'customer_name',
        'customer_email',
        'status',
        'priority',
        'initial_message',
        'has_predefined_answer',
        'last_message_at',
        'customer_acknowledged_recording',
        'session_data',
        'resolved_at',
        'resolved_by'
    ];

    protected $casts = [
        'has_predefined_answer' => 'boolean',
        'customer_acknowledged_recording' => 'boolean',
        'last_message_at' => 'datetime',
        'session_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer associated with this conversation
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the admin assigned to this conversation
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message in this conversation
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latest();
    }

    /**
     * Get unread messages count for admin
     */
    public function getUnreadMessagesCountAttribute()
    {
        return $this->messages()
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Mark all messages as read
     */
    public function markAllAsRead()
    {
        $this->messages()
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Create or find customer if email is provided
     */
    public function createOrFindCustomer()
    {
        if ($this->customer_email) {
            $customer = Customer::firstOrCreate(
                ['email' => $this->customer_email],
                ['name' => $this->customer_name]
            );
            $this->update(['customer_id' => $customer->id]);
            return $customer;
        }
        return null;
    }

    /**
     * Add a system message to the conversation
     */
    public function addSystemMessage($content)
    {
        return $this->messages()->create([
            'sender_type' => 'admin',
            'sender_id' => null,
            'message_content' => $content,
            'message_type' => 'system',
            'is_read' => true
        ]);
    }

    /**
     * Scope for active conversations
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for conversations with unread messages
     */
    public function scopeWithUnreadMessages($query)
    {
        return $query->whereHas('messages', function ($q) {
            $q->where('sender_type', 'customer')
              ->where('is_read', false);
        });
    }

    /**
     * Check if conversation has unread messages
     * Resolved/closed conversations should not show as unread
     */
    public function hasUnreadMessages()
    {
        // If conversation is resolved or closed, it shouldn't be considered as having unread messages
        if (in_array($this->status, [self::STATUS_RESOLVED, self::STATUS_CLOSED])) {
            return false;
        }
        
        return $this->messages()->where('sender_type', ChatMessage::SENDER_CUSTOMER)
                                ->where('is_read', false)
                                ->exists();
    }

    /**
     * Get count of unread messages
     * Resolved/closed conversations should not show unread count
     */
    public function unreadCount()
    {
        // If conversation is resolved or closed, return 0 unread count
        if (in_array($this->status, [self::STATUS_RESOLVED, self::STATUS_CLOSED])) {
            return 0;
        }
        
        return $this->messages()->where('sender_type', ChatMessage::SENDER_CUSTOMER)
                                ->where('is_read', false)
                                ->count();
    }
}
