<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all admins with their current (unencrypted) names
        $admins = DB::table('admins')->select('id', 'name')->whereNotNull('name')->get();
        
        echo "Found " . $admins->count() . " admin(s) to encrypt names for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->name && is_string($admin->name) && strlen(trim($admin->name)) > 0) {
                try {
                    // Check if it's already encrypted by trying to decrypt
                    $testDecrypt = Crypt::decrypt($admin->name);
                    echo "⚠️ Name for admin ID: {$admin->id} is already encrypted\n";
                    continue;
                } catch (\Exception $e) {
                    // Not encrypted, proceed with encryption
                }
                
                try {
                    // Encrypt the name
                    $encryptedName = Crypt::encrypt($admin->name);
                    
                    // Update the name column with encrypted data
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['name' => $encryptedName]);
                        
                    echo "✅ Encrypted name for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "❌ Failed to encrypt name for admin ID: {$admin->id} - {$e->getMessage()}\n";
                }
            } else {
                echo "⚠️ Name for admin ID: {$admin->id} is empty or invalid\n";
            }
        }
        
        echo "Name encryption migration completed.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all admins and decrypt their names
        $admins = DB::table('admins')->select('id', 'name')->whereNotNull('name')->get();
        
        echo "Found " . $admins->count() . " admin(s) to decrypt names for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->name) {
                try {
                    // Try to decrypt the name
                    $decryptedName = Crypt::decrypt($admin->name);
                    
                    // Update the name column with decrypted data
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['name' => $decryptedName]);
                        
                    echo "✅ Decrypted name for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "⚠️ Name for admin ID: {$admin->id} is not encrypted or empty\n";
                }
            }
        }
        
        echo "Name decryption migration completed.\n";
    }
};
