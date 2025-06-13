<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MLResponse;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MLResponseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing responses
        MLResponse::truncate();

        // Define initial responses
        $responses = [
            // Main intents (fallback responses)
            [
                'intent_key' => 'harga',
                'response' => '💰 **INFORMASI HARGA** | Silakan sebutkan produk spesifik untuk info harga detail. Kami ada berbagai pilihan harga dan paket khusus!',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'stok_produk',
                'response' => '📦 **CEK STOK PRODUK** | Sebutkan produk yang ingin dicek stocknya. Kami update stok real-time!',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'kategori_lighting',
                'response' => '💡 **KATEGORI LIGHTING** | Tersedia berbagai jenis lampu dan aksesori lighting untuk motor matic Anda!',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'kategori_mounting_body',
                'response' => '🏍️ **KATEGORI MOUNTING & BODY** | Tersedia mounting dan body kit berkualitas untuk motor matic!',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Harga sub-intents
            [
                'intent_key' => 'harga_harga_produk',
                'response' => '💰 **HARGA PRODUK SPESIFIK** | Harga mounting carbon: Rp 450.000-650.000, Body kit: Rp 800.000-1.200.000, Lampu LED: Rp 350.000-550.000, Projector: Rp 750.000-950.000. *Harga dapat berubah, konfirmasi via WhatsApp untuk harga terkini!',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'harga_harga_promo',
                'response' => '🎉 **PROMO & DISKON TERKINI** | Saat ini ada promo bundling mounting + lampu diskon 15%! Flash sale setiap Jumat jam 19:00. Member discount 10%. Follow IG @motorparts_bandung untuk update promo terbaru! 🔥',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'harga_harga_grosir',
                'response' => '🏪 **HARGA GROSIR & RESELLER** | Harga khusus reseller: diskon 20-30% untuk pembelian min 5 pcs. Sistem dropship tersedia. MOQ grosir: 10 pcs. Daftar jadi partner via WhatsApp untuk price list khusus! 💼',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'harga_harga_ongkir',
                'response' => '🚚 **BIAYA PENGIRIMAN** | Bandung-Cimahi: GRATIS ongkir! Luar kota: Rp 15.000-25.000. Same day delivery +Rp 10.000. COD gratis area Bandung. Express overnight +Rp 20.000. Cek ongkir eksak via WhatsApp! 📦',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'harga_harga_instalasi',
                'response' => '🔧 **BIAYA PEMASANGAN** | Jasa pasang mounting: Rp 50.000. Body kit install: Rp 100.000. Lampu setup: Rp 75.000. Home service +Rp 30.000. Weekend service normal rate. Paket install beli produk diskon 50%! ⚡',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Stok sub-intents
            [
                'intent_key' => 'stok_produk_stok_tersedia',
                'response' => '✅ **PRODUK READY STOCK** | Sebagian besar item ready stock! Mounting carbon, LED headlamp, body kit populer tersedia. Update stok real-time cek WhatsApp. Fast moving items selalu kami stock! 📦',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'stok_produk_stok_habis',
                'response' => '⏳ **RESTOCK SCHEDULE** | Item sold out biasanya restock 2-3 hari kerja. Import item 1-2 minggu. Limited edition by request. Join waiting list untuk prioritas stock! Info restock via broadcast WhatsApp 📱',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'stok_produk_stok_booking',
                'response' => '📝 **BOOKING & PRE-ORDER** | Bisa booking stock dengan DP 30%. Pre-order item khusus tersedia. Waiting list gratis! Notification otomatis saat stock ready. Booking berlaku 7 hari! 🎯',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Additional contextual responses
            [
                'intent_key' => 'motor_compatibility',
                'response' => '🏍️ **KOMPATIBILITAS MOTOR** | Produk tersedia untuk motor matic populer. Sebutkan tipe motor spesifik untuk cek compatibility. Custom fitting tersedia untuk motor langka! Konsultasi gratis via WhatsApp 💬',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'general_inquiry',
                'response' => '❓ **BANTUAN UMUM** | Silakan tanyakan hal spesifik tentang produk, harga, stok, atau pemasangan. Tim customer service kami siap membantu! WhatsApp aktif 09:00-17:00 WIB 📞',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'booking_pemasangan',
                'response' => '📅 **BOOKING PEMASANGAN** | Booking install bisa via WA/call. Jadwal weekday/weekend tersedia. Home service area Bandung +30rb. Estimasi 1-2 jam per produk. Konfirmasi H-1 sebelum install. Garansi pemasangan 6 bulan! 🔧',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'durasi_pengiriman',
                'response' => '🚚 **ESTIMASI PENGIRIMAN** | Same day delivery area Bandung (order sebelum 15:00). Luar kota 1-3 hari kerja via JNE/J&T. Gratis ongkir pembelian >500rb. Tracking number dikirim via WA. Barang dikemas bubble wrap + kardus! 📦',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'harga_produk',
                'response' => '💰 **DAFTAR HARGA PRODUK** | Mounting phone holder: Rp 75.000-150.000. Body kit Aerox: Rp 250.000-400.000. Lampu LED projector: Rp 180.000-350.000. DRL strip: Rp 120.000-200.000. Harga bervariasi sesuai kualitas dan merk! 🏷️',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'info_produk',
                'response' => 'ℹ️ **INFO PRODUK** | Spesialisasi aksesoris motor: Mounting phone holder, Body kit custom, Lampu LED/projector, DRL strip. Semua produk berkualitas tinggi dengan garansi. Katalog lengkap di website! 🛵',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'kontak_info',
                'response' => '📞 **KONTAK KAMI** | WhatsApp: 0812-3456-7890 | Telepon: (022) 1234-5678 | Email: info@boyzproject.com | Alamat: Jl. Contoh No.123, Bandung | Jam operasional: 08:00-17:00 WIB (Senin-Sabtu) 🏪',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'jam_operasional',
                'response' => '🕐 **JAM OPERASIONAL** | Senin-Jumat: 08:00-17:00 WIB | Sabtu: 08:00-15:00 WIB | Minggu: TUTUP | Customer service online 24/7 via WhatsApp untuk pertanyaan mendesak! ⏰',
                'category' => 'sub_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'promo_diskon',
                'response' => '🎉 **PROMO SPESIAL** | Diskon 15% pembelian >300rb | Paket install + produk diskon 50% jasa pasang | Gratis ongkir area Bandung min. 200rb | Member VIP cashback 10%! Promo terbatas, buruan order! 🔥',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'cara_pemesanan',
                'response' => '📝 **CARA PEMESANAN** | 1. Pilih produk di website/katalog | 2. Chat WA dengan kode produk | 3. Konfirmasi detail & alamat | 4. Transfer DP 50% | 5. Produk dikirim/dijadwalkan install | 6. Pelunasan saat terima barang! 🛒',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'garansi_produk',
                'response' => '🛡️ **GARANSI PRODUK** | Garansi produk 6-12 bulan (tergantung jenis) | Garansi pemasangan 6 bulan | Klaim garansi dengan bukti pembelian | Free service 1x dalam masa garansi | Penggantian jika cacat produksi! ✅',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'intent_key' => 'metode_pembayaran',
                'response' => '💳 **METODE PEMBAYARAN** | Transfer Bank: BCA, Mandiri, BRI | E-wallet: OVO, DANA, GoPay | COD area Bandung (+10rb) | Cicilan 0% kartu kredit | Crypto payment (Bitcoin, USDT) tersedia! 💰',
                'category' => 'main_intent',
                'is_active' => true,
                'usage_count' => 0,
                'metadata' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        // Insert responses
        foreach ($responses as $response) {
            MLResponse::updateOrCreate(
                ['intent_key' => $response['intent_key']],
                $response
            );
        }

        // Clear the response dictionary cache
        Cache::forget(config('ml.cache.response_dict_key'));

        $this->command->info('ML responses seeded successfully!');

        // Debug: dump all records
        dd(MLResponse::all());
    }
} 