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
        Schema::table('customers', function (Blueprint $table) {
            // Change columns to TEXT to accommodate encrypted data
            $table->text('name')->change();
            $table->text('email')->change();
            $table->text('phone')->nullable()->change();
        });
        
        echo "Customer columns changed to TEXT for encryption support\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('email', 255)->change();
            $table->string('phone', 20)->nullable()->change();
        });
    }
};
