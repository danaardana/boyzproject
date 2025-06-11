<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the name (decrypt if encrypted).
     */
    public function getNameAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Try to decrypt the value
            $decrypted = Crypt::decrypt($value);
            // If decryption succeeds and result looks like a name, return it
            if (is_string($decrypted) && strlen(trim($decrypted)) > 0) {
                return $decrypted;
            }
        } catch (\Exception $e) {
            // If decryption fails, check if it's already a plain name
            if (is_string($value) && strlen(trim($value)) > 0) {
                return $value;
            }
        }
        
        // Fallback: return the original value
        return $value;
    }

    /**
     * Set the name (encrypt before storing).
     */
    public function setNameAttribute($value)
    {
        if (!empty($value)) {
            try {
                $this->attributes['name'] = Crypt::encrypt($value);
            } catch (\Exception $e) {
                // If encryption fails, store as plain text
                $this->attributes['name'] = $value;
            }
        } else {
            $this->attributes['name'] = $value;
        }
    }

    /**
     * Get the email address (decrypt if encrypted).
     */
    public function getEmailAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Try to decrypt the value
            $decrypted = Crypt::decrypt($value);
            // If decryption succeeds and result looks like an email, return it
            if (filter_var($decrypted, FILTER_VALIDATE_EMAIL)) {
                return $decrypted;
            }
        } catch (\Exception $e) {
            // If decryption fails, check if it's already a plain email
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $value;
            }
        }
        
        // Fallback: return the original value
        return $value;
    }

    /**
     * Set the email address (encrypt before storing).
     */
    public function setEmailAttribute($value)
    {
        if (!empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL)) {
            try {
                $this->attributes['email'] = Crypt::encrypt($value);
            } catch (\Exception $e) {
                // If encryption fails, store as plain text
                $this->attributes['email'] = $value;
            }
        } else {
            $this->attributes['email'] = $value;
        }
    }

    /**
     * Get the phone number (decrypt if encrypted).
     */
    public function getPhoneAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Try to decrypt the value
            $decrypted = Crypt::decrypt($value);
            // If decryption succeeds and result looks like a phone number, return it
            if (is_string($decrypted) && strlen(trim($decrypted)) > 0) {
                return $decrypted;
            }
        } catch (\Exception $e) {
            // If decryption fails, return the original value
            return $value;
        }
        
        // Fallback: return the original value
        return $value;
    }

    /**
     * Set the phone number (encrypt before storing).
     */
    public function setPhoneAttribute($value)
    {
        if (!empty($value)) {
            try {
                $this->attributes['phone'] = Crypt::encrypt($value);
            } catch (\Exception $e) {
                // If encryption fails, store as plain text
                $this->attributes['phone'] = $value;
            }
        } else {
            $this->attributes['phone'] = $value;
        }
    }

    /**
     * Get the address (decrypt if encrypted).
     */
    public function getAddressAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Try to decrypt the value
            $decrypted = Crypt::decrypt($value);
            // If decryption succeeds and result looks like an address, return it
            if (is_string($decrypted) && strlen(trim($decrypted)) > 0) {
                return $decrypted;
            }
        } catch (\Exception $e) {
            // If decryption fails, return the original value
            return $value;
        }
        
        // Fallback: return the original value
        return $value;
    }

    /**
     * Set the address (encrypt before storing).
     */
    public function setAddressAttribute($value)
    {
        if (!empty($value)) {
            try {
                $this->attributes['address'] = Crypt::encrypt($value);
            } catch (\Exception $e) {
                // If encryption fails, store as plain text
                $this->attributes['address'] = $value;
            }
        } else {
            $this->attributes['address'] = $value;
        }
    }

    /**
     * Find a customer by email (handles both encrypted and plain emails)
     */
    public static function findByEmail($email)
    {
        // First try to find by plain email (for backward compatibility)
        $customers = static::all();
        foreach ($customers as $customer) {
            try {
                // Compare with decrypted email
                if ($customer->email === $email) {
                    return $customer;
                }
            } catch (\Exception $e) {
                // Continue to next customer if comparison fails
                continue;
            }
        }
        
        return null;
    }

    /**
     * Find a customer by name (handles both encrypted and plain names)
     */
    public static function findByName($name)
    {
        $customers = static::all();
        foreach ($customers as $customer) {
            try {
                // Compare with decrypted name
                if ($customer->name === $name) {
                    return $customer;
                }
            } catch (\Exception $e) {
                // Continue to next customer if comparison fails
                continue;
            }
        }
        
        return null;
    }

    /**
     * Relations
     */
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function chatConversations()
    {
        return $this->hasMany(ChatConversation::class);
    }

    public function getMessageHistory()
    {
        return $this->contactMessages()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');
    }

    public function getMessageStatusesByCategory()
    {
        return $this->contactMessages()
            ->get()
            ->groupBy('category')
            ->map(function ($messages) {
                $latest = $messages->first();
                return [
                    'status' => $latest->status,
                    'last_update' => $latest->last_update_time,
                    'count' => $messages->count()
                ];
            });
    }

    /**
     * Get customer's total contact messages count
     */
    public function getTotalMessagesAttribute()
    {
        return $this->contactMessages()->count();
    }

    /**
     * Get customer's total chat conversations count
     */
    public function getTotalConversationsAttribute()
    {
        return $this->chatConversations()->count();
    }

    /**
     * Get customer's latest activity
     */
    public function getLatestActivityAttribute()
    {
        $latestMessage = $this->contactMessages()->latest()->first();
        $latestConversation = $this->chatConversations()->latest()->first();
        
        if ($latestMessage && $latestConversation) {
            return $latestMessage->created_at->gt($latestConversation->created_at) 
                ? $latestMessage->created_at 
                : $latestConversation->created_at;
        } elseif ($latestMessage) {
            return $latestMessage->created_at;
        } elseif ($latestConversation) {
            return $latestConversation->created_at;
        }
        
        return $this->created_at;
    }

    /**
     * Check if customer has unread messages
     */
    public function hasUnreadMessages()
    {
        return $this->contactMessages()->where('is_read', false)->exists() ||
               $this->chatConversations()->whereHas('messages', function($q) {
                   $q->where('sender_type', 'customer')->where('is_read', false);
               })->exists();
    }
} 