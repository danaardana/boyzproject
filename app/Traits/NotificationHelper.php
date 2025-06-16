<?php

namespace App\Traits;

use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;

trait NotificationHelper
{
    /**
     * Create a notification for CRUD operations
     */
    protected function createCrudNotification(string $type, string $actionType, $model = null, array $metadata = [])
    {
        $admin = Auth::guard('admin')->user();
        
        if (!$admin) {
            return; // No admin logged in, skip notification
        }

        $actionModel = $model ? get_class($model) : null;
        $actionId = $model ? $model->id : null;

        // Generate title and message based on type and action
        $notificationData = $this->generateNotificationContent($type, $actionType, $model, $metadata);

        return AdminNotification::createNotification([
            'type' => $type,
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'action_type' => $actionType,
            'action_id' => $actionId,
            'action_model' => $actionModel,
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'user_email' => $admin->email,
            'metadata' => array_merge($metadata, [
                'admin_id' => $admin->id,
                'timestamp' => now()->toISOString(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ])
        ]);
    }

    /**
     * Generate notification content based on operation
     */
    private function generateNotificationContent(string $type, string $actionType, $model, array $metadata): array
    {
        $admin = Auth::guard('admin')->user();
        $adminName = $admin ? $admin->name : 'An admin';
        
        switch ($type) {
            case 'create':
                return [
                    'title' => ucfirst($actionType) . ' Created',
                    'message' => "{$adminName} created a new " . $this->getReadableActionType($actionType) . ($model && isset($model->title) ? ": {$model->title}" : '') . "."
                ];
                
            case 'update':
                return [
                    'title' => ucfirst($actionType) . ' Updated', 
                    'message' => "{$adminName} updated " . $this->getReadableActionType($actionType) . ($model && isset($model->title) ? ": {$model->title}" : '') . "."
                ];
                
            case 'delete':
                return [
                    'title' => ucfirst($actionType) . ' Deleted',
                    'message' => "{$adminName} deleted " . $this->getReadableActionType($actionType) . (!empty($metadata['item_name']) ? ": {$metadata['item_name']}" : '') . "."
                ];
                
            case 'login':
                return [
                    'title' => 'Admin Login',
                    'message' => "{$adminName} logged into the admin panel."
                ];
                
            case 'logout':
                return [
                    'title' => 'Admin Logout',
                    'message' => "{$adminName} logged out from the admin panel."
                ];
                
            default:
                return [
                    'title' => ucfirst($type) . ' Action',
                    'message' => "{$adminName} performed a {$type} action on " . $this->getReadableActionType($actionType) . "."
                ];
        }
    }

    /**
     * Convert action type to readable format
     */
    private function getReadableActionType(string $actionType): string
    {
        $readableTypes = [
            'section' => 'section',
            'section_content' => 'section content',
            'subsection' => 'subsection',
            'user' => 'user',
            'admin' => 'admin user',
            'product' => 'product',
            'portfolio' => 'portfolio item',
            'testimonial' => 'testimonial',
            'instagram' => 'Instagram feed',
            'tiktok' => 'TikTok feed',
            'promotion' => 'promotion',
            'category' => 'category',
            'message' => 'message',
            'contact' => 'contact message'
        ];

        return $readableTypes[$actionType] ?? $actionType;
    }

    /**
     * Quick methods for common CRUD operations
     */
    protected function notifyCreated(string $actionType, $model = null, array $metadata = [])
    {
        return $this->createCrudNotification('create', $actionType, $model, $metadata);
    }

    protected function notifyUpdated(string $actionType, $model = null, array $metadata = [])
    {
        return $this->createCrudNotification('update', $actionType, $model, $metadata);
    }

    protected function notifyDeleted(string $actionType, $model = null, array $metadata = [])
    {
        return $this->createCrudNotification('delete', $actionType, $model, $metadata);
    }

    protected function notifyLogin()
    {
        return $this->createCrudNotification('login', 'admin');
    }

    protected function notifyLogout()
    {
        return $this->createCrudNotification('logout', 'admin');
    }
} 