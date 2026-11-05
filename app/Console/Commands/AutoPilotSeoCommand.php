<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Post;
use App\Models\Setting;
use App\Services\AiService;
use App\Services\HyundaiNewsService;
use App\Services\TelegramNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AutoPilotSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyundai:auto-pilot {--force : Jalankan segera tanpa memeriksa jeda waktu interval}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatisasi pembaruan konten SEO dan sinkronisasi berita resmi Hyundai secara periodik untuk mendongkrak peringkat Google.';

    /**
     * Execute the console command.
     */
    public function handle(AiService $aiService, HyundaiNewsService $hyundaiNewsService): int
    {
        $this->info("=== MEMULAI AUTO-PILOT SEO CONTENT ENGINE ===");

        $isEnabled = (bool) Setting::get('auto_pilot_enabled', true);
        $force = (bool) $this->option('force');

        if (!$isEnabled && !$force) {
            $this->warn("Auto-pilot SEO sedang dinonaktifkan di System Settings. Lewati.");
            return Command::SUCCESS;
        }

        $frequency = Setting::get('auto_pilot_frequency', 'daily');
        $lastRun = Setting::get('auto_pilot_last_run_at');

        if (!$force && $lastRun) {
            $lastRunCarbon = Carbon::parse($lastRun);
            $hoursSinceLastRun = $lastRunCarbon->diffInHours(now());

            $minHours = match ($frequency) {
                'daily' => 20,           // Sekitar 1 hari
                'every_2_days' => 44,    // Sekitar 2 hari
                'twice_a_week' => 70,    // Sekitar 3 hari
                'weekly' => 140,         // Sekitar 6 hari
                default => 20,
            };

            if ($hoursSinceLastRun < $minHours) {
                $this->info("Pembaruan berkala belum jatuh tempo (Terakhir berjalan: {$lastRunCarbon->diffForHumans()}, Interval: {$frequency}). Lewati.");
                return Command::SUCCESS;
            }
        }

        // 1. Tarik Berita Resmi dari Hyundai.com
        $syncOfficial = (bool) Setting::get('auto_pilot_sync_official', true);
        if ($syncOfficial) {
            $this->info("1. Melakukan sinkronisasi berita resmi dari hyundai.com...");
            try {
                $stats = $hyundaiNewsService->syncNews(10);
                $this->info("   - Total berita dicek: {$stats['total_fetched']} | Baru: {$stats['created']} | Diperbarui: {$stats['updated']}");
            } catch (\Exception $e) {
                $this->warn("   - Gagal sinkronisasi berita resmi: " . $e->getMessage());
                Log::warning("AutoPilot: Gagal sync berita hyundai.com: " . $e->getMessage());
            }
        }

        // 2. Terbitkan Artikel SEO Baru Menggunakan AI Engine
        $generateAi = (bool) Setting::get('auto_pilot_generate_ai', true);
        if ($generateAi) {
            $this->info("2. Membuat artikel SEO lokal Surabaya baru dengan Gemini AI...");
            $topicData = $this->determineNextTopic();

            $this->info("   - Topik terpilih: {$topicData['topic']}");
            $this->info("   - Unit fokus: {$topicData['car']}");

            try {
                $article = $aiService->generateSeoArticle(
                    $topicData['topic'],
                    $topicData['car'],
                    'Keluarga, Eksekutif Muda, dan Pebisnis di Surabaya & sekitarnya',
                    $topicData['keywords']
                );

                $slug = Str::slug($article['title']);
                if (Post::where('slug', $slug)->exists()) {
                    $slug .= '-' . date('Ymd-His');
                }

                // Cari foto mobil yang relevan
                $car = !empty($topicData['car']) ? Car::where('name', 'like', "%{$topicData['car']}%")->first() : null;
                $imageUrl = $car?->image ?: 'https://www.hyundai.com/content/dam/hyundai/id/id/images/local/HYU_Logo_Vertical_Blue_RGB.png';

                $post = Post::create([
                    'title' => $article['title'],
                    'slug' => $slug,
                    'category' => $article['category'] ?? 'Tips',
                    'content' => $article['content'],
                    'image' => $imageUrl,
                    'source_name' => 'AutoShow AI SEO Editorial',
                    'source_url' => url('/'),
                    'is_published' => true,
                    'published_at' => now(),
                ]);

                $this->info("   - SUKSES! Artikel berhasil diterbitkan: '{$post->title}'");
                $this->info("   - URL: " . route('posts.show', $post->slug));

                // Kirim notifikasi jika Telegram diaktifkan
                if (Setting::get('telegram_notifications_enabled')) {
                    TelegramNotificationService::sendAlert('Artikel Baru Diterbitkan (Auto-Pilot SEO)', [
                        'Judul' => $post->title,
                        'Kategori' => $post->category,
                        'Tautan' => route('posts.show', $post->slug),
                    ]);
                }

                Log::info("AutoPilot SEO: Berhasil menerbitkan artikel '{$post->title}' [Slug: {$post->slug}]");

            } catch (\Exception $e) {
                $this->error("   - Gagal membuat artikel AI: " . $e->getMessage());
                Log::error("AutoPilot SEO Error: " . $e->getMessage());
            }
        }

        // Catat waktu eksekusi terakhir
        Setting::updateOrCreate(
            ['key' => 'auto_pilot_last_run_at'],
            ['value' => now()->toDateTimeString()]
        );

        $this->info("=== AUTO-PILOT SELESAI DENGAN SUKSES ===");
        return Command::SUCCESS;
    }

    /**
     * Tentukan topik berikutnya dari daftar rotasi atau pengaturan admin
     */
    protected function determineNextTopic(): array
    {
        $customTopicsJson = Setting::get('auto_pilot_custom_topics');
        $pool = [];

        if (!empty($customTopicsJson)) {
            $decoded = json_decode($customTopicsJson, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $pool = $decoded;
            }
        }

        if (empty($pool)) {
            $pool = [
                [
                    'topic' => 'Promo Diskon & Simulasi Cicilan Ringan Hyundai Stargazer Cartenz Surabaya 2026',
                    'car' => 'STARGAZER Cartenz',
                    'keywords' => 'Promo Stargazer Surabaya, Kredit Stargazer DP Murah, Dealer Hyundai HR Muhammad',
                ],
                [
                    'topic' => 'Review Lengkap Hyundai Creta Facelift vs Kompetitor: Pilihan Cerdas Keluarga Surabaya',
                    'car' => 'CRETA',
                    'keywords' => 'Review Hyundai Creta Surabaya, Harga OTR Creta 2026, Showroom Hyundai Surabaya Barat',
                ],
                [
                    'topic' => 'Menghitung Biaya Hemat Operasional Mobil Listrik Hyundai IONIQ 5 di Kota Surabaya',
                    'car' => 'IONIQ 5',
                    'keywords' => 'Mobil Listrik Surabaya, Biaya Cas IONIQ 5, SPKLU Surabaya, Garansi Baterai Hyundai',
                ],
                [
                    'topic' => 'Kemewahan & Ketangguhan All New Hyundai Santa Fe Hybrid untuk Perjalanan Luar Kota',
                    'car' => 'SANTA FE HEV',
                    'keywords' => 'Hyundai Santa Fe Hybrid Surabaya, Promo Santa Fe 2026, SUV Premium Surabaya',
                ],
                [
                    'topic' => 'Panduan Program Tukar Tambah (Trade-In) Mobil Bekas dengan Taksiran Tertinggi di Surabaya',
                    'car' => 'STARGAZER',
                    'keywords' => 'Tukar Tambah Mobil Surabaya, Trade In Hyundai, Jual Mobil Lama Surabaya',
                ],
                [
                    'topic' => 'All New KONA Electric: Rekomendasi SUV Listrik Jarak Tempuh Terjauh untuk Rute Surabaya - Malang',
                    'car' => 'KONA Electric',
                    'keywords' => 'Kona Electric Surabaya, Mobil Listrik Murah Surabaya, Hyundai EV HR Muhammad',
                ],
                [
                    'topic' => 'Keunggulan Layanan Bengkel Resmi & Layanan Home Service Hyundai HR Muhammad Surabaya',
                    'car' => 'CRETA N Line',
                    'keywords' => 'Bengkel Resmi Hyundai Surabaya, Service Mobil Hyundai, Suku Cadang Asli Mobis',
                ],
                [
                    'topic' => 'Kenali Kecanggihan Teknologi Hyundai SmartSense & Bluelink untuk Menembus Padatnya Jalanan Surabaya',
                    'car' => 'PALISADE',
                    'keywords' => 'Hyundai SmartSense, Hyundai Bluelink, Fitur Keselamatan Hyundai, Dealer Surabaya',
                ],
                [
                    'topic' => 'Review Hyundai Staria Luxury MPV: Kenyamanan First Class untuk Pejabat & Pebisnis Surabaya',
                    'car' => 'STARIA',
                    'keywords' => 'Hyundai Staria Surabaya, Harga Staria OTR Surabaya, Luxury MPV Surabaya',
                ],
                [
                    'topic' => 'Bocoran All New Hyundai IONIQ 9 Flagship SUV Listrik 3 Baris Pertama di Indonesia',
                    'car' => 'IONIQ 9',
                    'keywords' => 'Hyundai IONIQ 9 Surabaya, Mobil Listrik 7 Seater, Flagship EV Hyundai',
                ],
            ];
        }

        // Cari topik yang judulnya belum pernah diterbitkan belakangan
        $recentTitles = Post::latest('published_at')->take(10)->pluck('title')->toArray();

        foreach ($pool as $item) {
            $alreadyExists = false;
            foreach ($recentTitles as $title) {
                if (Str::contains(strtolower($title), strtolower($item['car'] ?? ''))) {
                    $alreadyExists = true;
                    break;
                }
            }
            if (!$alreadyExists) {
                return $item;
            }
        }

        // Jika semua sudah pernah, pilih acak dari daftar
        return $pool[array_rand($pool)];
    }
}
