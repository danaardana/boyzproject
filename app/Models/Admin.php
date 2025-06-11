<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

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
        'security_code_expires_at',
        'avatar_path'
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

    /**
     * Get the email address (decrypt if encrypted).
     */
    public function getEmailAttribute($value)
    {
        return $this->decryptAttribute($value, 'email');
    }

    /**
     * Set the email address (encrypt before storing).
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $this->encryptAttribute($value, 'email');
    }

    /**
     * Get the name (decrypt if encrypted).
     */
    public function getNameAttribute($value)
    {
        return $this->decryptAttribute($value, 'name');
    }

    /**
     * Set the name (encrypt before storing).
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $this->encryptAttribute($value, 'name');
    }

    /**
     * Generic method to decrypt an attribute.
     */
    protected function decryptAttribute($value, $type = 'generic')
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Try to decrypt the value
            $decrypted = Crypt::decrypt($value);
            
            // Validate based on type
            if ($type === 'email' && filter_var($decrypted, FILTER_VALIDATE_EMAIL)) {
                return $decrypted;
            } elseif ($type === 'name' && is_string($decrypted) && strlen(trim($decrypted)) > 0) {
                return $decrypted;
            } elseif ($type === 'generic') {
                return $decrypted;
            }
        } catch (\Exception $e) {
            // If decryption fails, check if it's already in plain format
            if ($type === 'email' && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $value;
            } elseif ($type === 'name' && is_string($value) && strlen(trim($value)) > 0) {
                return $value;
            }
        }
        
        // Fallback: return the original value
        return $value;
    }

    /**
     * Generic method to encrypt an attribute.
     */
    protected function encryptAttribute($value, $type = 'generic')
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Validate input based on type before encryption
            $shouldEncrypt = false;
            
            if ($type === 'email' && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $shouldEncrypt = true;
            } elseif ($type === 'name' && is_string($value) && strlen(trim($value)) > 0) {
                $shouldEncrypt = true;
            } elseif ($type === 'generic') {
                $shouldEncrypt = true;
            }

            if ($shouldEncrypt) {
                return Crypt::encrypt($value);
            } else {
                // If not valid format, store as is (might already be encrypted)
                return $value;
            }
        } catch (\Exception $e) {
            // If encryption fails, store as plain text (fallback)
            return $value;
        }
    }

    /**
     * Check if email value is already encrypted
     */
    private function isEmailEncrypted($value): bool
    {
        if (empty($value)) {
            return false;
        }

        try {
            Crypt::decrypt($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if email value is already decrypted (plain text email format)
     */
    private function isEmailDecrypted($value): bool
    {
        return !empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Find an admin by email (handles both encrypted and plain emails)
     */
    public static function findByEmail($email)
    {
        return static::findByAttribute('email', $email);
    }

    /**
     * Find an admin by name (handles both encrypted and plain names)
     */
    public static function findByName($name)
    {
        return static::findByAttribute('name', $name);
    }

    /**
     * Generic method to find admin by any encrypted attribute
     */
    protected static function findByAttribute($attribute, $value)
    {
        // First try to find by plain value (for backward compatibility)
        $admin = static::where($attribute, $value)->first();
        
        if (!$admin) {
            // If not found, try to find by encrypted value
            // We need to use raw DB query to get encrypted values
            $admins = \Illuminate\Support\Facades\DB::table('admins')->get();
            foreach ($admins as $adminRecord) {
                try {
                    $encryptedValue = $adminRecord->{$attribute};
                    $decryptedValue = \Illuminate\Support\Facades\Crypt::decrypt($encryptedValue);
                    if ($decryptedValue === $value) {
                        // Found matching record, return Eloquent model
                        return static::find($adminRecord->id);
                    }
                } catch (\Exception $e) {
                    // Continue to next record if decryption fails
                    continue;
                }
            }
        }
        
        return $admin;
    }
}
