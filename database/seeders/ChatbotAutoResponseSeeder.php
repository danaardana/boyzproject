<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatbotAutoResponseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('chatbot_auto_responses')->truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('chatbot_auto_responses')->insert([
            // Quick greeting responses
            [
                'keyword' => 'hai',
                'response' => 'Hai! 👋 Selamat datang di Boys Project! Kami siap membantu Anda dengan sparepart motor terbaik. Ada yang bisa kami bantu?',
                'is_active' => true,
                'priority' => 1,
                'additional_keywords' => json_encode(['halo', 'hello', 'hi', 'selamat']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Greeting response for customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keyword' => 'saya butuh bantuan',
                'response' => 'Tentu! 😊 Saya siap membantu Anda. Silakan pilih topik yang ingin Anda tanyakan atau ketik pertanyaan langsung.',
                'is_active' => true,
                'priority' => 1,
                'additional_keywords' => json_encode(['bantuan', 'help', 'tolong', 'butuh']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Help request response',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Price related responses
            [
                'keyword' => 'harga',
                'response' => '💰 **INFORMASI HARGA** | Untuk info harga terbaru, silakan sebutkan produk yang Anda cari. Contoh: "harga mounting aerox" atau "harga lampu LED". Kami juga ada promo menarik lho! 🔥',
                'is_active' => true,
                'priority' => 1,
                'additional_keywords' => json_encode(['price', 'biaya', 'cost', 'berapa']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Price inquiry response',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keyword' => 'info kontak',
                'response' => '📞 **KONTAK KAMI** | WhatsApp: 08211990442 | Jam operasional: Senin-Jumat 08:00-17:00, Sabtu-Minggu 10:00-16:00 | Lokasi: Cimahi, Bandung | Siap melayani Anda! 😊',
                'is_active' => true,
                'priority' => 1,
                'additional_keywords' => json_encode(['kontak', 'contact', 'telepon', 'whatsapp', 'alamat']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Contact information response',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Availability responses
            [
                'keyword' => 'jam operasional',
                'response' => '⏰ **JAM OPERASIONAL** | Senin - Jumat: 08:00 - 17:00 WIB | Sabtu - Minggu: 10:00 - 16:00 WIB | Untuk respon cepat, hubungi WhatsApp kami di 08211990442! 📱',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['jam', 'buka', 'tutup', 'operasional', 'waktu']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Operating hours information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keyword' => 'stok',
                'response' => '📦 **CEK STOK** | Untuk mengecek ketersediaan stok, sebutkan produk yang Anda cari. Contoh: "stok mounting vario" atau "ada lampu projector?". Stok kami update real-time! ✅',
                'is_active' => true,
                'priority' => 1,
                'additional_keywords' => json_encode(['stock', 'tersedia', 'ada', 'ready', 'available']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Stock availability inquiry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Product categories
            [
                'keyword' => 'produk apa saja',
                'response' => '🛍️ **PRODUK KAMI** | 💡 Lampu & LED | 🏍️ Mounting & Body Kit | ⚙️ Aksesoris Motor | 🔧 Jasa Pemasangan | Semua produk berkualitas tinggi dengan garansi! Mau lihat yang mana?',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['produk', 'katalog', 'jual', 'kategori']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Product catalog information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keyword' => 'mounting',
                'response' => '🏍️ **MOUNTING & BODY KIT** | Tersedia mounting carbon untuk berbagai motor matic. Harga mulai Rp 450.000. Presisi tinggi, mudah pasang, garansi kualitas! Mau tanya untuk motor apa?',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['mounting', 'body kit', 'carbon']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Mounting and body kit information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keyword' => 'lampu',
                'response' => '💡 **LAMPU & LED** | LED headlamp, projector, lampu sein tersedia! Harga mulai Rp 350.000. Terang, hemat listrik, tahan lama. Cocok untuk motor matic dan sport!',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['led', 'projector', 'headlamp', 'sein']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Lighting products information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Service related
            [
                'keyword' => 'pemasangan',
                'response' => '🔧 **JASA PEMASANGAN** | Mounting: Rp 50.000 | Body kit: Rp 100.000 | Lampu: Rp 75.000 | Home service +Rp 30.000 | Teknisi berpengalaman, hasil rapi! 👨‍🔧',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['pasang', 'install', 'service', 'teknisi']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Installation service information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Shipping & delivery
            [
                'keyword' => 'pengiriman',
                'response' => '🚚 **PENGIRIMAN** | Bandung-Cimahi: GRATIS ongkir! | Luar kota: Rp 15.000-25.000 | Same day delivery: +Rp 10.000 | COD tersedia area Bandung | Aman & cepat sampai! 📦',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['kirim', 'ongkir', 'cod', 'delivery', 'ekspedisi']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Shipping and delivery information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Promo & discounts
            [
                'keyword' => 'promo',
                'response' => '🎉 **PROMO TERBARU** | Bundling mounting + lampu diskon 15%! | Flash sale Jumat 19:00 | Member discount 10% | Follow IG @boyprojects untuk update promo! Ada yang mau ditanya? 🔥',
                'is_active' => true,
                'priority' => 2,
                'additional_keywords' => json_encode(['diskon', 'sale', 'discount', 'murah']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Promotional offers information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // General inquiry
            [
                'keyword' => 'terima kasih',
                'response' => 'Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain, jangan ragu untuk bertanya ya! Boys Project siap melayani kebutuhan motor Anda! 🏍️✨',
                'is_active' => true,
                'priority' => 3,
                'additional_keywords' => json_encode(['thanks', 'makasih', 'terimakasih']),
                'match_type' => 'contains',
                'case_sensitive' => false,
                'description' => 'Thank you response',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        echo "Chatbot auto responses seeded successfully! 🎉\n";
    }
} 