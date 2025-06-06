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
        // Clear existing data first to avoid conflicts
        Schema::disableForeignKeyConstraints();
        
        // Truncate tables in reverse order (to respect foreign key constraints)
        \DB::table('product_option_values')->truncate();
        \DB::table('product_options')->truncate();
        \DB::table('products')->truncate();
        
        Schema::enableForeignKeyConstraints();

        // Add new columns to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->after('name');
            $table->integer('stock')->default(0)->after('description');
            $table->integer('sold')->default(0)->after('stock');
            $table->integer('ratings')->default(0)->after('sold');
            $table->decimal('average_rating', 2, 1)->default(0.0)->after('ratings');
        });

        // Add status column to product_option_values table
        Schema::table('product_option_values', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove added columns from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'stock', 'sold', 'ratings', 'average_rating']);
        });

        // Remove status column from product_option_values table
        Schema::table('product_option_values', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });
    }
};
