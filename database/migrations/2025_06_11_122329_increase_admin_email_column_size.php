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
        // Get current indexes on email column
        $indexes = DB::select("SHOW INDEX FROM admins WHERE Column_name = 'email'");
        
        echo "Found " . count($indexes) . " indexes on email column\n";
        
        // Drop all indexes on email column
        foreach ($indexes as $index) {
            try {
                echo "Dropping index: " . $index->Key_name . "\n";
                if ($index->Key_name === 'PRIMARY') {
                    continue; // Skip primary key
                }
                DB::statement("ALTER TABLE admins DROP INDEX `{$index->Key_name}`");
            } catch (\Exception $e) {
                echo "Failed to drop index {$index->Key_name}: " . $e->getMessage() . "\n";
            }
        }
        
        // Change email column to TEXT to accommodate encrypted data
        Schema::table('admins', function (Blueprint $table) {
            $table->text('email')->change();
        });
        
        echo "Email column changed to TEXT\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Revert back to original email column size (varchar 100)
            $table->string('email', 100)->change();
        });
        
        // Recreate unique constraint
        Schema::table('admins', function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
