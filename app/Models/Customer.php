<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
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
} 