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
        if (!Schema::hasTable('ml_responses')) {
            Schema::create('ml_responses', function (Blueprint $table) {
                $table->id();
                $table->string('intent_key')->unique();
                $table->text('response');
                $table->string('category')->default('main_intent');
                $table->boolean('is_active')->default(true);
                $table->integer('usage_count')->default(0);
                $table->json('metadata')->nullable();
                $table->unsignedBigInteger('auto_response_id')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
                $table->foreign('auto_response_id')->references('id')->on('chatbot_auto_responses')->onDelete('set null');
                $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
                $table->index(['intent_key', 'category', 'is_active']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ml_responses');
    }
}; 