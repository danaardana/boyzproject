<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all recent notifications for admin navbar
     */
    public function getRecentNotifications(Request $request): JsonResponse
    {
        try {
            $notifications = Notification::recent(10)->get();
            $unreadCount = Notification::unread()->count();

            return response()->json([
                'success' => true,
                'notifications' => $notifications->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon,
                        'color' => $notification->color,
                        'type' => $notification->type,
                        'user_type' => $notification->user_type,
                        'user_name' => $notification->user_name ?? 'System',
                        'is_read' => $notification->is_read,
                        'time_ago' => $notification->time_ago,
                        'formatted_date' => $notification->formatted_date,
                        'created_at' => $notification->created_at->toISOString(),
                    ];
                }),
                'unread_count' => $unreadCount,
                'breakdown' => [
                    'admin' => Notification::unread()->byUserType('admin')->count(),
                    'customer' => Notification::unread()->byUserType('customer')->count(),
                    'system' => Notification::unread()->byUserType('system')->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->markAsRead();

            $unreadCount = Notification::unread()->count();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unreadCount' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        try {
            $affectedRows = Notification::markAllAsRead();

            return response()->json([
                'success' => true,
                'message' => "All notifications marked as read ({$affectedRows} updated)",
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove all notifications
     */
    public function removeAll(Request $request): JsonResponse
    {
        try {
            $deletedCount = Notification::count();
            Notification::truncate();

            return response()->json([
                'success' => true,
                'message' => "All notifications removed ({$deletedCount} deleted)",
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove all notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a single notification
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            $unreadCount = Notification::unread()->count();

            return response()->json([
                'success' => true,
                'message' => 'Notification removed',
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notification statistics
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            $stats = [
                'total' => Notification::count(),
                'unread' => Notification::unread()->count(),
                'read' => Notification::read()->count(),
                'today' => Notification::whereDate('created_at', today())->count(),
                'this_week' => Notification::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'by_type' => Notification::selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type')
                    ->toArray(),
                'by_user_type' => Notification::selectRaw('user_type, COUNT(*) as count')
                    ->groupBy('user_type')
                    ->pluck('count', 'user_type')
                    ->toArray()
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notification statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
