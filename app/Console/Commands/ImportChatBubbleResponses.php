<?php

namespace App\Console\Commands;

use App\Models\ChatbotAutoResponse;
use Illuminate\Console\Command;

class ImportChatBubbleResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:import-responses {--force : Force import even if responses already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import auto responses from chat-bubble.js to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if auto responses already exist
        if (ChatbotAutoResponse::count() > 0 && !$this->option('force')) {
            $this->error('Auto responses already exist in database. Use --force to overwrite.');
            return Command::FAILURE;
        }

        // Define the auto responses from chat-bubble.js
        $autoResponses = [
            [
                'keyword' => 'halo',
                'response' => 'Halo! Bagaimana saya bisa membantu Anda hari ini?',
                'match_type' => 'contains',
                'priority' => 10,
                'description' => 'Greeting in Indonesian'
            ],
            [
                'keyword' => 'hai',
                'response' => 'Hai! Ada yang bisa saya bantu?',
                'match_type' => 'contains',
                'priority' => 10,
                'description' => 'Informal greeting in Indonesian'
            ],
            [
                'keyword' => 'help',
                'response' => 'Saya di sini untuk membantu! Apa yang Anda butuhkan?',
                'match_type' => 'contains',
                'priority' => 20,
                'description' => 'Help request in English'
            ],
            [
                'keyword' => 'bantuan',
                'response' => 'Saya di sini untuk membantu! Apa yang Anda butuhkan?',
                'match_type' => 'contains',
                'priority' => 20,
                'description' => 'Help request in Indonesian'
            ],
            [
                'keyword' => 'kontak',
                'response' => 'Anda bisa menghubungi kami di contact@boysproject.com atau telepon 08211990442',
                'match_type' => 'contains',
                'priority' => 50,
                'description' => 'Contact information request'
            ],
            [
                'keyword' => 'jam',
                'response' => 'Jam operasional kami adalah Senin-Jumat 09:00-18:00 WIB',
                'match_type' => 'contains',
                'priority' => 30,
                'description' => 'Operating hours inquiry',
                'additional_keywords' => ['jam kerja', 'jam buka', 'operasional']
            ],
            [
                'keyword' => 'harga',
                'response' => 'Untuk informasi harga, silakan kunjungi halaman harga kami atau hubungi tim penjualan.',
                'match_type' => 'contains',
                'priority' => 40,
                'description' => 'Pricing inquiry in Indonesian',
                'additional_keywords' => ['biaya', 'tarif', 'cost']
            ],
            [
                'keyword' => 'pricing',
                'response' => 'Untuk informasi harga, silakan kunjungi halaman harga kami atau hubungi tim penjualan.',
                'match_type' => 'contains',
                'priority' => 40,
                'description' => 'Pricing inquiry in English',
                'additional_keywords' => ['price', 'cost', 'rate']
            ],
            [
                'keyword' => 'demo',
                'response' => 'Apakah Anda ingin menjadwalkan demo? Saya bisa membantu Anda memulai!',
                'match_type' => 'contains',
                'priority' => 60,
                'description' => 'Demo request',
                'additional_keywords' => ['demonstration', 'trial', 'preview']
            ],
            [
                'keyword' => 'terima kasih',
                'response' => 'Sama-sama! Ada hal lain yang bisa saya bantu?',
                'match_type' => 'contains',
                'priority' => 5,
                'description' => 'Thank you in Indonesian',
                'additional_keywords' => ['makasih', 'thanks']
            ],
            [
                'keyword' => 'thanks',
                'response' => 'Sama-sama! Ada hal lain yang bisa saya bantu?',
                'match_type' => 'contains',
                'priority' => 5,
                'description' => 'Thank you in English',
                'additional_keywords' => ['thank you', 'thx']
            ],
            [
                'keyword' => 'selamat tinggal',
                'response' => 'Selamat tinggal! Jangan ragu untuk menghubungi kami jika butuh bantuan.',
                'match_type' => 'contains',
                'priority' => 5,
                'description' => 'Goodbye in Indonesian',
                'additional_keywords' => ['dadah', 'sampai jumpa']
            ],
            [
                'keyword' => 'bye',
                'response' => 'Selamat tinggal! Jangan ragu untuk menghubungi kami jika butuh bantuan.',
                'match_type' => 'contains',
                'priority' => 5,
                'description' => 'Goodbye in English',
                'additional_keywords' => ['goodbye', 'see you']
            ],
            [
                'keyword' => 'email',
                'response' => 'Email kami adalah contact@boysproject.com. Kami akan merespons dalam 24 jam.',
                'match_type' => 'contains',
                'priority' => 30,
                'description' => 'Email inquiry'
            ],
            [
                'keyword' => 'whatsapp',
                'response' => 'Nomor WhatsApp kami: 08211990442. Kami siap membantu Anda!',
                'match_type' => 'contains',
                'priority' => 30,
                'description' => 'WhatsApp contact',
                'additional_keywords' => ['wa', 'telp', 'telepon']
            ],
            [
                'keyword' => 'layanan',
                'response' => 'Kami menyediakan berbagai layanan digital. Silakan lihat portfolio kami atau hubungi kami untuk konsultasi gratis!',
                'match_type' => 'contains',
                'priority' => 35,
                'description' => 'Service inquiry',
                'additional_keywords' => ['service', 'jasa']
            ],
            [
                'keyword' => 'portfolio',
                'response' => 'Anda dapat melihat portfolio kami di halaman utama website. Kami bangga dengan proyek-proyek yang telah kami selesaikan!',
                'match_type' => 'contains',
                'priority' => 35,
                'description' => 'Portfolio inquiry',
                'additional_keywords' => ['portofolio', 'karya', 'hasil kerja']
            ]
        ];

        if ($this->option('force')) {
            $this->info('Clearing existing auto responses...');
            ChatbotAutoResponse::truncate();
        }

        $this->info('Importing auto responses from chat-bubble.js...');
        $progressBar = $this->output->createProgressBar(count($autoResponses));
        $progressBar->start();

        $importedCount = 0;
        $errorCount = 0;

        foreach ($autoResponses as $responseData) {
            try {
                ChatbotAutoResponse::create([
                    'keyword' => $responseData['keyword'],
                    'response' => $responseData['response'],
                    'match_type' => $responseData['match_type'],
                    'priority' => $responseData['priority'],
                    'description' => $responseData['description'],
                    'additional_keywords' => $responseData['additional_keywords'] ?? [],
                    'case_sensitive' => false,
                    'is_active' => true,
                    'created_by' => null, // System created
                    'updated_by' => null,
                ]);
                $importedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to import response for keyword '{$responseData['keyword']}': " . $e->getMessage());
                $errorCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($importedCount > 0) {
            $this->info("Successfully imported {$importedCount} auto responses!");
        }

        if ($errorCount > 0) {
            $this->warn("Failed to import {$errorCount} responses. Check the error messages above.");
        }

        $this->info('Import completed!');
        $this->table(
            ['Status', 'Count'],
            [
                ['Imported', $importedCount],
                ['Failed', $errorCount],
                ['Total in Database', ChatbotAutoResponse::count()]
            ]
        );

        return Command::SUCCESS;
    }
}
