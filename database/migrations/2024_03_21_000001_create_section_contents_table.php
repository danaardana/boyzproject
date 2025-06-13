<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionContentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('section_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id');
            $table->string('content_key');
            $table->text('content_value')->nullable();
            $table->string('type')->default('text');
            $table->longText('extra_data')->nullable();
            $table->integer('show_order')->default(0);
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_contents');
    }
} 