<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type')->after('id'); // 'create', 'update', 'delete', 'login', 'logout', etc.
            $table->string('title')->after('type');
            $table->text('message')->after('title');
            $table->string('icon')->nullable()->after('message'); // Icon class for notification
            $table->string('color')->default('primary')->after('icon'); // Bootstrap color class
            $table->string('action_type')->after('color'); // 'user', 'admin', 'section', 'content', 'product', etc.
            $table->unsignedBigInteger('action_id')->nullable()->after('action_type'); // ID of the affected record
            $table->string('action_model')->nullable()->after('action_id'); // Model class that was affected
            $table->unsignedBigInteger('user_id')->nullable()->after('action_model'); // User who performed the action
            $table->string('user_type')->default('system')->after('user_id'); // 'admin', 'customer', 'system'
            $table->string('user_name')->nullable()->after('user_type'); // Name of user who performed action
            $table->string('user_email')->nullable()->after('user_name'); // Email of user who performed action
            $table->json('metadata')->nullable()->after('user_email'); // Additional data about the action
            $table->boolean('is_read')->default(false)->after('metadata');
            $table->timestamp('read_at')->nullable()->after('is_read');

            // Add indexes for better performance
            $table->index(['type', 'is_read']);
            $table->index(['user_type', 'user_id']);
            $table->index(['action_type', 'action_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['type', 'is_read']);
            $table->dropIndex(['user_type', 'user_id']);
            $table->dropIndex(['action_type', 'action_id']);
            $table->dropIndex(['created_at']);
            
            $table->dropColumn([
                'type', 'title', 'message', 'icon', 'color', 'action_type', 
                'action_id', 'action_model', 'user_id', 'user_type', 
                'user_name', 'user_email', 'metadata', 'is_read', 'read_at'
            ]);
        });
    }
};
