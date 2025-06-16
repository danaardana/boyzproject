<?php

namespace App\Traits;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

trait NotificationHelper
{
    /**
     * Create a notification for CRUD operations
     */
    protected function createCrudNotification(string $type, string $actionType, $model = null, array $metadata = [], string $userType = 'admin')
    {
        // Determine which guard to use based on user type
        $user = $this->getCurrentUser($userType);
        
        if (!$user) {
            // If no user is logged in, create a system notification
            return $this->createSystemNotification($type, $actionType, $model, $metadata);
        }

        $actionModel = $model ? get_class($model) : null;
        $actionId = $model ? $model->id : null;

        // Generate title and message based on type and action
        $notificationData = $this->generateNotificationContent($type, $actionType, $model, $metadata, $user);

        return Notification::createNotification([
            'type' => $type,
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'action_type' => $actionType,
            'action_id' => $actionId,
            'action_model' => $actionModel,
            'user_id' => $user->id,
            'user_type' => $userType,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'metadata' => array_merge($metadata, [
                'user_id' => $user->id,
                'user_type' => $userType,
                'timestamp' => now()->toISOString(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ])
        ]);
    }

    /**
     * Create a system notification when no user is logged in
     */
    protected function createSystemNotification(string $type, string $actionType, $model = null, array $metadata = [])
    {
        $actionModel = $model ? get_class($model) : null;
        $actionId = $model ? $model->id : null;

        $notificationData = $this->generateSystemNotificationContent($type, $actionType, $model, $metadata);

        return Notification::createNotification([
            'type' => $type,
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'action_type' => $actionType,
            'action_id' => $actionId,
            'action_model' => $actionModel,
            'user_type' => 'system',
            'user_name' => 'System',
            'metadata' => array_merge($metadata, [
                'timestamp' => now()->toISOString(),
                'automated' => true
            ])
        ]);
    }

    /**
     * Get current authenticated user based on type
     */
    private function getCurrentUser(string $userType)
    {
        switch ($userType) {
            case 'admin':
                return Auth::guard('admin')->user();
            case 'customer':
            case 'user':
                return Auth::guard('web')->user();
            default:
                // Try to detect the current guard
                if (Auth::guard('admin')->check()) {
                    return Auth::guard('admin')->user();
                } elseif (Auth::guard('web')->check()) {
                    return Auth::guard('web')->user();
                }
                return null;
        }
    }

    /**
     * Generate notification content based on operation
     */
    private function generateNotificationContent(string $type, string $actionType, $model, array $metadata, $user): array
    {
        $userName = $user ? $user->name : 'A user';
        $modelName = $this->getModelDisplayName($model, $actionType);
        
        switch ($type) {
            case 'create':
                return [
                    'title' => ucfirst($actionType) . ' Created',
                    'message' => "{$userName} created a new {$modelName}" . $this->getModelTitle($model) . "."
                ];
                
            case 'update':
                return [
                    'title' => ucfirst($actionType) . ' Updated', 
                    'message' => "{$userName} updated {$modelName}" . $this->getModelTitle($model) . "."
                ];
                
            case 'delete':
                return [
                    'title' => ucfirst($actionType) . ' Deleted',
                    'message' => "{$userName} deleted {$modelName}" . $this->getItemName($metadata, $model) . "."
                ];
                
            case 'login':
                return [
                    'title' => 'User Login',
                    'message' => "{$userName} logged into the system."
                ];
                
            case 'logout':
                return [
                    'title' => 'User Logout',
                    'message' => "{$userName} logged out from the system."
                ];
                
            default:
                return [
                    'title' => ucfirst($type) . ' Action',
                    'message' => "{$userName} performed a {$type} action on {$modelName}."
                ];
        }
    }

    /**
     * Generate system notification content
     */
    private function generateSystemNotificationContent(string $type, string $actionType, $model, array $metadata): array
    {
        $modelName = $this->getModelDisplayName($model, $actionType);
        
        switch ($type) {
            case 'create':
                return [
                    'title' => 'System: ' . ucfirst($actionType) . ' Created',
                    'message' => "System automatically created a new {$modelName}" . $this->getModelTitle($model) . "."
                ];
                
            case 'update':
                return [
                    'title' => 'System: ' . ucfirst($actionType) . ' Updated',
                    'message' => "System automatically updated {$modelName}" . $this->getModelTitle($model) . "."
                ];
                
            case 'delete':
                return [
                    'title' => 'System: ' . ucfirst($actionType) . ' Deleted',
                    'message' => "System automatically deleted {$modelName}" . $this->getItemName($metadata, $model) . "."
                ];
                
            default:
                return [
                    'title' => 'System: ' . ucfirst($type) . ' Action',
                    'message' => "System performed a {$type} action on {$modelName}."
                ];
        }
    }

    /**
     * Get model display name
     */
    private function getModelDisplayName($model, string $actionType): string
    {
        if ($model) {
            $className = class_basename($model);
            return strtolower(preg_replace('/(?<!^)[A-Z]/', ' $0', $className));
        }
        
        return $this->getReadableActionType($actionType);
    }

    /**
     * Get model title for display
     */
    private function getModelTitle($model): string
    {
        if (!$model) return '';
        
        if (isset($model->title) && $model->title) {
            return ": {$model->title}";
        } elseif (isset($model->name) && $model->name) {
            return ": {$model->name}";
        } elseif (isset($model->email) && $model->email) {
            return ": {$model->email}";
        }
        
        return " (ID: {$model->id})";
    }

    /**
     * Get item name from metadata or model
     */
    private function getItemName(array $metadata, $model): string
    {
        if (!empty($metadata['item_name'])) {
            return ": {$metadata['item_name']}";
        }
        
        return $this->getModelTitle($model);
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
            'customer' => 'customer',
            'admin' => 'admin user',
            'product' => 'product',
            'portfolio' => 'portfolio item',
            'testimonial' => 'testimonial',
            'instagram' => 'Instagram feed',
            'tiktok' => 'TikTok feed',
            'promotion' => 'promotion',
            'category' => 'category',
            'message' => 'message',
            'contact' => 'contact message',
            'chat' => 'chat message',
            'conversation' => 'conversation',
            'response' => 'response'
        ];

        return $readableTypes[$actionType] ?? $actionType;
    }

    /**
     * Quick methods for common CRUD operations
     */
    protected function notifyCreated(string $actionType, $model = null, array $metadata = [], string $userType = 'admin')
    {
        return $this->createCrudNotification('create', $actionType, $model, $metadata, $userType);
    }

    protected function notifyUpdated(string $actionType, $model = null, array $metadata = [], string $userType = 'admin')
    {
        return $this->createCrudNotification('update', $actionType, $model, $metadata, $userType);
    }

    protected function notifyDeleted(string $actionType, $model = null, array $metadata = [], string $userType = 'admin')
    {
        return $this->createCrudNotification('delete', $actionType, $model, $metadata, $userType);
    }

    protected function notifyLogin(string $userType = 'admin')
    {
        return $this->createCrudNotification('login', $userType, null, [], $userType);
    }

    protected function notifyLogout(string $userType = 'admin')
    {
        return $this->createCrudNotification('logout', $userType, null, [], $userType);
    }

    /**
     * Create notifications for specific user types
     */
    protected function notifyAdmin(string $type, string $actionType, $model = null, array $metadata = [])
    {
        return $this->createCrudNotification($type, $actionType, $model, $metadata, 'admin');
    }

    protected function notifyCustomer(string $type, string $actionType, $model = null, array $metadata = [])
    {
        return $this->createCrudNotification($type, $actionType, $model, $metadata, 'customer');
    }

    protected function notifySystem(string $type, string $actionType, $model = null, array $metadata = [])
    {
        return $this->createSystemNotification($type, $actionType, $model, $metadata);
    }
} 