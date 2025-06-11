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
        // Get all admins with their current (unencrypted) emails
        $admins = DB::table('admins')->select('id', 'email')->whereNotNull('email')->get();
        
        echo "Found " . $admins->count() . " admin(s) to encrypt emails for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->email && filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                try {
                    // Encrypt the email
                    $encryptedEmail = Crypt::encrypt($admin->email);
                    
                    // Update the email column with encrypted data
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['email' => $encryptedEmail]);
                        
                    echo "✅ Encrypted email for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "❌ Failed to encrypt email for admin ID: {$admin->id} - {$e->getMessage()}\n";
                }
            } else {
                echo "⚠️ Email for admin ID: {$admin->id} is not a valid email or empty\n";
            }
        }
        
        echo "Email encryption migration completed.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all admins and decrypt their emails
        $admins = DB::table('admins')->select('id', 'email')->whereNotNull('email')->get();
        
        echo "Found " . $admins->count() . " admin(s) to decrypt emails for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->email) {
                try {
                    // Try to decrypt the email
                    $decryptedEmail = Crypt::decrypt($admin->email);
                    
                    // Update the email column with decrypted data
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['email' => $decryptedEmail]);
                        
                    echo "✅ Decrypted email for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "⚠️ Email for admin ID: {$admin->id} is not encrypted or empty\n";
                }
            }
        }
        
        echo "Email decryption migration completed.\n";
    }
};
