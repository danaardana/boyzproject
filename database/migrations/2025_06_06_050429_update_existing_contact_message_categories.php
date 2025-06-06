<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ContactMessage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map old category values to new standardized values
        $categoryMappings = [
            'garansi' => ContactMessage::CATEGORY_WARRANTY,
            'pemasangan' => ContactMessage::CATEGORY_INSTALLATION,
            'lain' => ContactMessage::CATEGORY_GENERAL,
            'lainnya' => ContactMessage::CATEGORY_GENERAL,
        ];

        // Update existing contact messages with old category values
        foreach ($categoryMappings as $oldCategory => $newCategory) {
            \DB::table('contact_messages')
                ->where('category', $oldCategory)
                ->update(['category' => $newCategory]);
        }

        // Log the changes
        \Log::info('Contact message categories updated', [
            'mappings' => $categoryMappings,
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the category mappings if needed
        $reverseMappings = [
            ContactMessage::CATEGORY_WARRANTY => 'garansi',
            ContactMessage::CATEGORY_INSTALLATION => 'pemasangan',
            ContactMessage::CATEGORY_GENERAL => 'lain',
        ];

        foreach ($reverseMappings as $newCategory => $oldCategory) {
            \DB::table('contact_messages')
                ->where('category', $newCategory)
                ->update(['category' => $oldCategory]);
        }
    }
};
