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
        // Get all customers with their current (unencrypted) data
        $customers = DB::table('customers')
            ->select('id', 'name', 'email', 'phone')
            ->whereNotNull('name')
            ->orWhereNotNull('email')
            ->orWhereNotNull('phone')
            ->get();
        
        echo "Found " . $customers->count() . " customer(s) to encrypt data for.\n";
        
        foreach ($customers as $customer) {
            $updates = [];
            
            // Encrypt name if present and not already encrypted
            if ($customer->name && is_string($customer->name) && strlen(trim($customer->name)) > 0) {
                try {
                    // Check if it's already encrypted by trying to decrypt
                    $testDecrypt = Crypt::decrypt($customer->name);
                    echo "Name for customer ID {$customer->id} is already encrypted\n";
                } catch (\Exception $e) {
                    // Not encrypted, so encrypt it
                    try {
                        $encryptedName = Crypt::encrypt($customer->name);
                        $updates['name'] = $encryptedName;
                        echo "Encrypted name for customer ID {$customer->id}\n";
                    } catch (\Exception $e) {
                        echo "Failed to encrypt name for customer ID {$customer->id}: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            // Encrypt email if present and not already encrypted
            if ($customer->email && filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                try {
                    // Check if it's already encrypted by trying to decrypt
                    $testDecrypt = Crypt::decrypt($customer->email);
                    echo "Email for customer ID {$customer->id} is already encrypted\n";
                } catch (\Exception $e) {
                    // Not encrypted, so encrypt it
                    try {
                        $encryptedEmail = Crypt::encrypt($customer->email);
                        $updates['email'] = $encryptedEmail;
                        echo "Encrypted email for customer ID {$customer->id}\n";
                    } catch (\Exception $e) {
                        echo "Failed to encrypt email for customer ID {$customer->id}: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            // Encrypt phone if present and not already encrypted
            if ($customer->phone && is_string($customer->phone) && strlen(trim($customer->phone)) > 0) {
                try {
                    // Check if it's already encrypted by trying to decrypt
                    $testDecrypt = Crypt::decrypt($customer->phone);
                    echo "Phone for customer ID {$customer->id} is already encrypted\n";
                } catch (\Exception $e) {
                    // Not encrypted, so encrypt it
                    try {
                        $encryptedPhone = Crypt::encrypt($customer->phone);
                        $updates['phone'] = $encryptedPhone;
                        echo "Encrypted phone for customer ID {$customer->id}\n";
                    } catch (\Exception $e) {
                        echo "Failed to encrypt phone for customer ID {$customer->id}: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            // Update the customer record if there are changes
            if (!empty($updates)) {
                DB::table('customers')
                    ->where('id', $customer->id)
                    ->update($updates);
            }
        }
        
        echo "Customer data encryption completed\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all customers and decrypt their data
        $customers = DB::table('customers')
            ->select('id', 'name', 'email', 'phone')
            ->get();
        
        echo "Decrypting customer data...\n";
        
        foreach ($customers as $customer) {
            $updates = [];
            
            // Decrypt name
            if ($customer->name) {
                try {
                    $decryptedName = Crypt::decrypt($customer->name);
                    $updates['name'] = $decryptedName;
                } catch (\Exception $e) {
                    // Already decrypted or invalid data
                }
            }
            
            // Decrypt email
            if ($customer->email) {
                try {
                    $decryptedEmail = Crypt::decrypt($customer->email);
                    $updates['email'] = $decryptedEmail;
                } catch (\Exception $e) {
                    // Already decrypted or invalid data
                }
            }
            
            // Decrypt phone
            if ($customer->phone) {
                try {
                    $decryptedPhone = Crypt::decrypt($customer->phone);
                    $updates['phone'] = $decryptedPhone;
                } catch (\Exception $e) {
                    // Already decrypted or invalid data
                }
            }
            
            // Update the customer record if there are changes
            if (!empty($updates)) {
                DB::table('customers')
                    ->where('id', $customer->id)
                    ->update($updates);
            }
        }
        
        echo "Customer data decryption completed\n";
    }
};
