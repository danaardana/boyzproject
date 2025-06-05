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
        // Drop unused e-commerce tables that don't have corresponding models
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('ecommerce_transactions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('ecommerce_platforms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tables if needed (basic structure only)
        Schema::create('ecommerce_platforms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('ecommerce_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
