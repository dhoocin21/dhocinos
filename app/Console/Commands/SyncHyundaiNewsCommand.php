<?php

namespace App\Console\Commands;

use App\Services\HyundaiNewsService;
use Illuminate\Console\Command;

class SyncHyundaiNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyundai:sync-news {--limit=20 : Maximum number of articles to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarik dan sinkronkan berita resmi otomatis langsung dari https://www.hyundai.com/id/en/hyundai-story/news';

    /**
     * Execute the console command.
     */
    public function handle(HyundaiNewsService $service): int
    {
        $limit = (int) $this->option('limit');
        $this->info("Menghubungi server resmi Hyundai Indonesia (hyundai.com)...");

        $stats = $service->syncNews($limit);

        if (isset($stats['error_message'])) {
            $this->error("Gagal sinkronisasi: " . $stats['error_message']);
            return Command::FAILURE;
        }

        $this->info("Berhasil! Total terambil: {$stats['total_fetched']} | Baru: {$stats['created']} | Diperbarui: {$stats['updated']}");
        return Command::SUCCESS;
    }
}
