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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'create', 'update', 'delete', 'login', 'logout', etc.
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // Icon class for notification
            $table->string('color')->default('primary'); // Bootstrap color class
            $table->string('action_type'); // 'user', 'section', 'content', 'product', etc.
            $table->unsignedBigInteger('action_id')->nullable(); // ID of the affected record
            $table->string('action_model')->nullable(); // Model class that was affected
            $table->unsignedBigInteger('user_id')->nullable(); // Admin who performed the action
            $table->string('user_name')->nullable(); // Name of admin who performed action
            $table->string('user_email')->nullable(); // Email of admin who performed action
            $table->json('metadata')->nullable(); // Additional data about the action
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
