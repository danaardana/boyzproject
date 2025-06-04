<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageResponse extends Model
{
    // Only use created_at timestamp, disable updated_at
    const UPDATED_AT = null;
    
    protected $fillable = [
        'contact_message_id',
        'admin_id',
        'message',
    ];

    /**
     * Get the contact message that owns the response.
     */
    public function contactMessage(): BelongsTo
    {
        return $this->belongsTo(ContactMessage::class);
    }

    /**
     * Get the admin who created the response.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
