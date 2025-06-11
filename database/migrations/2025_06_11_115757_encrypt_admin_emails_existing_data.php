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
        // Get all admins with their current (unencrypted) emails using raw DB queries
        // to avoid conflicts with Eloquent casts
        $admins = DB::table('admins')->select('id', 'email')->whereNotNull('email')->get();
        
        echo "Found " . $admins->count() . " admin(s) to encrypt emails for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->email && !$this->isAlreadyEncrypted($admin->email)) {
                try {
                    // Encrypt the email using Laravel's encryption
                    $encryptedEmail = Crypt::encrypt($admin->email);
                    
                    // Update the database with encrypted email using raw query
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['email' => $encryptedEmail]);
                        
                    echo "✅ Encrypted email for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "❌ Failed to encrypt email for admin ID: {$admin->id} - {$e->getMessage()}\n";
                }
            } else {
                echo "⚠️ Email for admin ID: {$admin->id} is already encrypted or empty\n";
            }
        }
        
        echo "Email encryption migration completed.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Decrypt all emails back to plain text
        $admins = DB::table('admins')->select('id', 'email')->whereNotNull('email')->get();
        
        echo "Found " . $admins->count() . " admin(s) to decrypt emails for.\n";
        
        foreach ($admins as $admin) {
            if ($admin->email && $this->isAlreadyEncrypted($admin->email)) {
                try {
                    // Decrypt the email
                    $decryptedEmail = Crypt::decrypt($admin->email);
                    
                    // Update the database with decrypted email
                    DB::table('admins')
                        ->where('id', $admin->id)
                        ->update(['email' => $decryptedEmail]);
                        
                    echo "✅ Decrypted email for admin ID: {$admin->id}\n";
                } catch (\Exception $e) {
                    echo "❌ Failed to decrypt email for admin ID: {$admin->id} - {$e->getMessage()}\n";
                }
            } else {
                echo "⚠️ Email for admin ID: {$admin->id} is not encrypted or empty\n";
            }
        }
        
        echo "Email decryption migration completed.\n";
    }
    
    /**
     * Check if a string is already encrypted
     */
    private function isAlreadyEncrypted($value): bool
    {
        // Laravel encrypted values start with 'eyJpdiI6' (base64 encoded JSON)
        if (empty($value)) {
            return false;
        }
        
        try {
            Crypt::decrypt($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
};
