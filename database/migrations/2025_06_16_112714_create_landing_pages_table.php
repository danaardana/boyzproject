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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul halaman landing
            $table->text('content'); // Konten utama halaman landing, bisa berupa HTML atau Markdown
            $table->string('slug')->unique(); // Untuk URL yang SEO friendly (misal: /about-us)
            $table->string('meta_title')->nullable(); // SEO: Meta Title
            $table->text('meta_description')->nullable(); // SEO: Meta Description
            $table->string('hero_image')->nullable(); // Path gambar hero section
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif halaman
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};