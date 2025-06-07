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
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->string('customer_name'); // Required field
            $table->string('customer_email')->nullable(); // Optional field
            $table->enum('status', ['active', 'resolved', 'closed'])->default('active');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->text('initial_question')->nullable(); // The question that started the chat
            $table->boolean('has_predefined_answer')->default(false); // Whether question had predefined answer
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('customer_acknowledged_recording')->default(false); // Chat recording consent
            $table->json('session_data')->nullable(); // Store additional session info
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'created_at']);
            $table->index(['customer_email']);
            $table->index(['admin_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
