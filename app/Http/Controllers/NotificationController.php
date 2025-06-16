<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all recent notifications for admin navbar
     */
    public function getRecentNotifications(Request $request): JsonResponse
    {
        try {
            $notifications = AdminNotification::recent(10)->get();
            $unreadCount = AdminNotification::getUnreadCount();

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
                        'is_read' => $notification->is_read,
                        'time_ago' => $notification->time_ago,
                        'formatted_date' => $notification->formatted_date,
                        'created_at' => $notification->created_at->toISOString(),
                    ];
                }),
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notifications'
            ], 500);
        }
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        try {
            $notification = AdminNotification::findOrFail($id);
            $notification->markAsRead();

            $unreadCount = AdminNotification::getUnreadCount();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        try {
            $affectedRows = AdminNotification::markAllAsRead();

            return response()->json([
                'success' => true,
                'message' => "All notifications marked as read ({$affectedRows} updated)",
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }

    /**
     * Remove all notifications
     */
    public function removeAll(Request $request): JsonResponse
    {
        try {
            $deletedCount = AdminNotification::count();
            AdminNotification::truncate();

            return response()->json([
                'success' => true,
                'message' => "All notifications removed ({$deletedCount} deleted)",
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove all notifications'
            ], 500);
        }
    }

    /**
     * Delete a single notification
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $notification = AdminNotification::findOrFail($id);
            $notification->delete();

            $unreadCount = AdminNotification::getUnreadCount();

            return response()->json([
                'success' => true,
                'message' => 'Notification removed',
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove notification'
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
                'total' => AdminNotification::count(),
                'unread' => AdminNotification::unread()->count(),
                'read' => AdminNotification::read()->count(),
                'today' => AdminNotification::whereDate('created_at', today())->count(),
                'this_week' => AdminNotification::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'by_type' => AdminNotification::selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type')
                    ->toArray()
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notification statistics'
            ], 500);
        }
    }
}
