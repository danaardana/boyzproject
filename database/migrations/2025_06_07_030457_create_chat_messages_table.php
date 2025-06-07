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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->onDelete('cascade');
            $table->enum('sender_type', ['customer', 'admin']);
            $table->foreignId('sender_id')->nullable(); // admin_id when sender_type is admin, null for customers
            $table->text('message_content');
            $table->enum('message_type', ['text', 'image', 'file', 'system'])->default('text');
            $table->boolean('is_read')->default(false);
            $table->json('metadata')->nullable(); // For storing file paths, image URLs, etc.
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['conversation_id', 'created_at']);
            $table->index(['sender_type', 'is_read']);
            
            // Add foreign key constraint for admin sender
            $table->foreign('sender_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
