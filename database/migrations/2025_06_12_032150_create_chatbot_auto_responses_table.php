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
        Schema::create('chatbot_auto_responses', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->index(); // Keywords that trigger this response
            $table->text('response'); // The auto response message
            $table->boolean('is_active')->default(true); // Whether this response is active
            $table->integer('priority')->default(0); // Priority for response matching (higher number = higher priority)
            $table->json('additional_keywords')->nullable(); // Additional keywords/phrases that can trigger this response
            $table->enum('match_type', ['exact', 'contains', 'starts_with', 'ends_with'])->default('contains'); // How to match keywords
            $table->boolean('case_sensitive')->default(false); // Whether matching should be case sensitive
            $table->text('description')->nullable(); // Description of what this auto response is for
            $table->unsignedBigInteger('created_by')->nullable(); // Admin who created this
            $table->unsignedBigInteger('updated_by')->nullable(); // Admin who last updated this
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

            // Indexes for better performance
            $table->index(['is_active', 'priority']);
            $table->index('match_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_auto_responses');
    }
};
