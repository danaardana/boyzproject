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
        Schema::table('admins', function (Blueprint $table) {
            // Update name column to varchar(50)
            $table->string('name', 50)->change();
            
            // Update email column to varchar(100) 
            $table->string('email', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Revert name column to default varchar(255)
            $table->string('name', 255)->change();
            
            // Revert email column to default varchar(255)
            $table->string('email', 255)->change();
        });
    }
};
