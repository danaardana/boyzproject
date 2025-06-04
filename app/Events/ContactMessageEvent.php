<?php

namespace App\Events;

use App\Models\ContactMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $unreadCount;
    public $recentMessages;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        // Get unread messages count
        $this->unreadCount = ContactMessage::where('is_read', false)->count();
        
        // Get recent messages (last 5) with customer info
        $this->recentMessages = ContactMessage::with('customer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'customer_name' => $message->customer->name ?? 'Unknown',
                    'content' => $message->content,
                    'created_at' => $message->created_at->diffForHumans(),
                ];
            });
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        // Use public channel for easier testing (change to private later if needed)
        return new Channel('admin.notifications');
    }

    public function broadcastAs()
    {
        return 'ContactMessageEvent';
    }
} 