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
        Schema::table('chat_conversations', function (Blueprint $table) {
            // Rename initial_question to initial_message to match the model
            $table->renameColumn('initial_question', 'initial_message');
            
            // Add missing fields that the model expects
            $table->timestamp('resolved_at')->nullable()->after('session_data');
            $table->foreignId('resolved_by')->nullable()->constrained('admins')->onDelete('set null')->after('resolved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('initial_message', 'initial_question');
            $table->dropForeign(['resolved_by']);
            $table->dropColumn(['resolved_at', 'resolved_by']);
        });
    }
};
