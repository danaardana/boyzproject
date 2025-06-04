<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin'; // Gunakan guard 'admin'

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'is_active',
        'verified',
        'security_code',
        'security_code_expires_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'security_code'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified' => 'boolean',
        'security_code_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get messages assigned to this admin
     */
    public function assignedMessages()
    {
        return $this->hasMany(ContactMessage::class, 'admin_id');
    }

    /**
     * Get all contact messages (with optional filters)
     */
    public function getAllMessages($filters = [])
    {
        $query = ContactMessage::query();

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['assigned_to'])) {
            $query->where('admin_id', $filters['assigned_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Assign a message to an admin
     */
    public function assignMessage($messageId, $adminId = null)
    {
        $message = ContactMessage::findOrFail($messageId);
        
        return $message->update([
            'admin_id' => $adminId ?? $this->id,
            'status' => ContactMessage::STATUS_IN_PROGRESS,
            'last_update_time' => now(),
        ]);
    }

    /**
     * Add an admin response to a message
     */
    public function respondToMessage($messageId, $response)
    {
        $message = ContactMessage::findOrFail($messageId);
        $extraData = $message->extra_data ?? [];
        
        if (!isset($extraData['responses'])) {
            $extraData['responses'] = [];
        }
        
        $extraData['responses'][] = [
            'message' => $response,
            'admin_id' => $this->id,
            'created_at' => now()
        ];
        
        return $message->update([
            'extra_data' => $extraData,
            'last_update_time' => now(),
        ]);
    }

    /**
     * Update message status
     */
    public function updateMessageStatus($messageId, $status)
    {
        $message = ContactMessage::findOrFail($messageId);
        $extraData = $message->extra_data ?? [];
        
        $extraData['status'] = $status;
        $extraData['updated_at'] = now();
        
        if ($status === Customer::STATUS_RESOLVED || $status === Customer::STATUS_CLOSED) {
            $extraData['resolved_by'] = $this->id;
            $extraData['resolved_at'] = now();
        }
        
        return $message->update([
            'extra_data' => $extraData,
            'last_update_time' => now(),
        ]);
    }

    /**
     * Get message statistics
     */
    public function getMessageStats()
    {
        $messages = ContactMessage::all();
        
        return [
            'total' => $messages->count(),
            'by_category' => $messages->groupBy(function ($message) {
                return $message->category;
            })->map->count(),
            'by_status' => $messages->groupBy(function ($message) {
                return $message->status;
            })->map->count(),
            'unassigned' => $messages->filter(function ($message) {
                return empty($message->admin_id);
            })->count()
        ];
    }

    /**
     * Generate a new security code for password reset
     */
    public function generateSecurityCode()
    {
        $this->security_code = strtoupper(substr(md5(uniqid()), 0, 8));
        $this->security_code_expires_at = now()->addHours(1); // Code expires in 1 hour
        $this->save();

        return $this->security_code;
    }

    /**
     * Verify if the security code is valid
     */
    public function verifySecurityCode($code)
    {
        if ($this->security_code === null || 
            $this->security_code_expires_at === null || 
            $this->security_code_expires_at < now()) {
            return false;
        }

        return strtoupper($code) === $this->security_code;
    }

    /**
     * Clear the security code after use
     */
    public function clearSecurityCode()
    {
        $this->security_code = null;
        $this->security_code_expires_at = null;
        $this->save();
    }

    /**
     * Check if admin is verified
     */
    public function isVerified()
    {
        return $this->verified === true;
    }

    /**
     * Mark admin as verified
     */
    public function markAsVerified()
    {
        $this->verified = true;
        $this->save();
        return $this;
    }

    /**
     * Mark admin as unverified
     */
    public function markAsUnverified()
    {
        $this->verified = false;
        $this->save();
        return $this;
    }

    /**
     * Scope to get only verified admins
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Scope to get only unverified admins
     */
    public function scopeUnverified($query)
    {
        return $query->where('verified', false);
    }
}
