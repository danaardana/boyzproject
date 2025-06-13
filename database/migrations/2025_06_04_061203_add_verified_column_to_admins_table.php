<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('admins', 'is_active')) {
            Schema::table('admins', function (Blueprint $table) {
                 $table->boolean('is_active')->default(true)->after('password');
            });
        }
        if (!Schema::hasColumn('admins', 'verified')) {
            Schema::table('admins', function (Blueprint $table) {
                 $table->boolean('verified')->default(false)->after('is_active');
            });
            // Update all existing admin records so that verified is set to true (1)
             DB::table('admins')->update(['verified' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
};
