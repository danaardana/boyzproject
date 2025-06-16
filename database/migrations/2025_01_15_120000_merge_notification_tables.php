<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, migrate data from admin_notifications to notifications
        if (Schema::hasTable('admin_notifications')) {
            // Get all admin notifications
            $adminNotifications = DB::table('admin_notifications')->get();
            
            foreach ($adminNotifications as $notification) {
                DB::table('notifications')->insert([
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'icon' => $notification->icon,
                    'color' => $notification->color,
                    'action_type' => $notification->action_type,
                    'action_id' => $notification->action_id,
                    'action_model' => $notification->action_model,
                    'user_id' => $notification->user_id,
                    'user_type' => 'admin', // Set as admin type
                    'user_name' => $notification->user_name,
                    'user_email' => $notification->user_email,
                    'metadata' => $notification->metadata,
                    'is_read' => $notification->is_read,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at,
                ]);
            }
        }
        
        // Drop the admin_notifications table since we've merged everything
        Schema::dropIfExists('admin_notifications');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate admin_notifications table
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->string('color')->default('primary');
            $table->string('action_type');
            $table->unsignedBigInteger('action_id')->nullable();
            $table->string('action_model')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
        
        // Move admin notifications back
        $adminNotifications = DB::table('notifications')
            ->where('user_type', 'admin')
            ->get();
            
        foreach ($adminNotifications as $notification) {
            DB::table('admin_notifications')->insert([
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'icon' => $notification->icon,
                'color' => $notification->color,
                'action_type' => $notification->action_type,
                'action_id' => $notification->action_id,
                'action_model' => $notification->action_model,
                'user_id' => $notification->user_id,
                'user_name' => $notification->user_name,
                'user_email' => $notification->user_email,
                'metadata' => $notification->metadata,
                'is_read' => $notification->is_read,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,
            ]);
        }
        
        // Remove admin notifications from the unified table
        DB::table('notifications')->where('user_type', 'admin')->delete();
    }
}; 