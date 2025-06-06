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
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_id')->constrained('product_options')->onDelete('cascade');
            $table->string('value'); // e.g., 'Honda Vario', 'Yamaha', 'pair', 'single'
            $table->string('display_value'); // e.g., 'Honda Vario 150cc', 'Yamaha Mio', 'Pair (2 units)', 'Single Unit'
            $table->decimal('price_adjustment', 10, 2)->default(0); // Price adjustment for this option
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
