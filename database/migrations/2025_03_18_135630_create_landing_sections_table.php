<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');  // Nama bagian (hero, about, services, dll.)
            $table->text('content')->nullable(); // Konten HTML/CSS/JS atau JSON
            $table->boolean('is_active')->default(true); // Aktif atau tidak
            $table->integer('order')->default(0); // Urutan tampilan pada landing page
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_sections');
    }
};
