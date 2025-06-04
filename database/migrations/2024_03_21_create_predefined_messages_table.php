<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('predefined_messages', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable(); // For grouping messages (e.g., FAQ, Common Issues, etc.)
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->boolean('show_in_faq')->default(false); // Whether to show in FAQ section
            $table->boolean('show_in_chat')->default(true); // Whether to show in chat suggestions
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predefined_messages');
    }
}; 