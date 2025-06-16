<?php

namespace App\Observers;

use App\Traits\NotificationHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NotificationObserver
{
    use NotificationHelper;

    /**
     * Models that should not trigger notifications
     */
    protected array $excludedModels = [
        'App\Models\Notification',
        'App\Models\AdminNotification',
        'App\Models\Session',
        'Illuminate\Notifications\DatabaseNotification',
    ];

    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        if ($this->shouldNotify($model)) {
            $actionType = $this->getActionType($model);
            $userType = $this->getUserType($model);
            
            $this->notifyCreated($actionType, $model, [
                'model_class' => get_class($model),
                'model_id' => $model->id,
                'created_at' => $model->created_at?->toISOString(),
            ], $userType, $this->shouldCreateBoth($model));
        }
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated(Model $model): void
    {
        if ($this->shouldNotify($model)) {
            $actionType = $this->getActionType($model);
            $userType = $this->getUserType($model);
            
            // Get the changes made to the model
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            $this->notifyUpdated($actionType, $model, [
                'model_class' => get_class($model),
                'model_id' => $model->id,
                'changes' => $changes,
                'original' => $original,
                'updated_at' => $model->updated_at?->toISOString(),
            ], $userType, $this->shouldCreateBoth($model));
        }
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        if ($this->shouldNotify($model)) {
            $actionType = $this->getActionType($model);
            $userType = $this->getUserType($model);
            
            // Store model data before deletion
            $modelData = $model->toArray();
            
            $this->notifyDeleted($actionType, null, [
                'model_class' => get_class($model),
                'model_id' => $model->id,
                'item_name' => $this->getItemName($model),
                'model_data' => $modelData,
                'deleted_at' => now()->toISOString(),
            ], $userType, $this->shouldCreateBoth($model));
        }
    }

    /**
     * Determine if the model should trigger notifications
     */
    protected function shouldNotify(Model $model): bool
    {
        $modelClass = get_class($model);
        
        // Skip excluded models
        if (in_array($modelClass, $this->excludedModels)) {
            return false;
        }

        // Skip if model has a method to disable notifications
        if (method_exists($model, 'shouldNotify') && !$model->shouldNotify()) {
            return false;
        }

        return true;
    }

    /**
     * Get the action type for the model
     */
    protected function getActionType(Model $model): string
    {
        $className = class_basename($model);
        
        // Convert PascalCase to snake_case
        $actionType = Str::snake($className);
        
        // Map specific models to more descriptive action types
        $mappings = [
            'section_content' => 'section_content',
            'admin' => 'admin',
            'customer' => 'customer',
            'product' => 'product',
            'chat_message' => 'chat',
            'chat_conversation' => 'conversation',
            'contact_message' => 'contact',
            'ml_response' => 'response',
            'chatbot_auto_response' => 'chatbot_response',
        ];

        return $mappings[$actionType] ?? $actionType;
    }

    /**
     * Determine the user type for the model
     */
    protected function getUserType(Model $model): string
    {
        $className = class_basename($model);
        
        // Map models to user types
        $userTypeMappings = [
            'Admin' => 'admin',
            'Customer' => 'customer',
            'User' => 'customer',
            'ChatMessage' => 'customer',
            'ChatConversation' => 'customer',
            'ContactMessage' => 'customer',
        ];

        return $userTypeMappings[$className] ?? 'admin';
    }

    /**
     * Determine if notifications should be created in both tables
     */
    protected function shouldCreateBoth(Model $model): bool
    {
        $className = class_basename($model);
        
        // Models that should create notifications in both tables
        $bothTableModels = [
            'Customer',
            'ChatMessage',
            'ChatConversation',
            'ContactMessage',
        ];

        return in_array($className, $bothTableModels);
    }

    /**
     * Get a descriptive name for the item being affected
     */
    protected function getItemName(Model $model): string
    {
        if (isset($model->title) && $model->title) {
            return $model->title;
        } elseif (isset($model->name) && $model->name) {
            return $model->name;
        } elseif (isset($model->email) && $model->email) {
            return $model->email;
        } elseif (isset($model->subject) && $model->subject) {
            return $model->subject;
        } elseif (isset($model->message) && $model->message) {
            return Str::limit($model->message, 50);
        }
        
        return class_basename($model) . ' #' . $model->id;
    }
} 