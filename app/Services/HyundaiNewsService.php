<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HyundaiNewsService
{
    protected string $apiUrl = 'https://www.hyundai.com/wsvc/template_en/spa/common/news/newsList.html';

    /**
     * Sync latest news directly from Hyundai Indonesia (hyundai.com)
     */
    public function syncNews(int $limit = 20): array
    {
        $stats = [
            'total_fetched' => 0,
            'created' => 0,
            'updated' => 0,
            'errors' => 0,
        ];

        try {
            // 1. Fetch Local News (Indonesia specific)
            $localItems = $this->fetchFromHyundai('L', 0, $limit);
            
            // 2. Fetch Global News (Major global headlines)
            $globalItems = $this->fetchFromHyundai('G', 0, 5);

            $allItems = array_merge($localItems, $globalItems);
            $stats['total_fetched'] = count($allItems);

            foreach ($allItems as $item) {
                try {
                    $this->saveOrUpdateArticle($item, $stats);
                } catch (\Throwable $e) {
                    $stats['errors']++;
                    Log::warning('Error syncing single Hyundai news item: ' . $e->getMessage(), ['item' => $item]);
                }
            }

            // Save last sync timestamp
            Setting::set('hyundai_news_last_synced_at', now()->toDateTimeString());
            Setting::set('hyundai_news_count', Post::whereNotNull('seq')->count());

        } catch (\Throwable $e) {
            Log::error('HyundaiNewsService sync failed: ' . $e->getMessage());
            $stats['error_message'] = $e->getMessage();
        }

        return $stats;
    }

    /**
     * Fetch news items from Hyundai official SPA API
     */
    protected function fetchFromHyundai(string $newsType, int $startNum, int $endNum): array
    {
        $response = Http::asForm()
            ->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://www.hyundai.com/id/en/hyundai-story/news',
                'Origin' => 'https://www.hyundai.com',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])
            ->withoutVerifying()
            ->post($this->apiUrl, [
                'loc' => 'ID',
                'lang' => 'en',
                'newsType' => $newsType,
                's_word' => '',
                'startNum' => $startNum,
                'endNum' => $endNum,
                'seq' => '',
                'detailNewsType' => '',
            ]);

        if (!$response->successful()) {
            Log::error("Hyundai news API returned status {$response->status()} for type {$newsType}");
            return [];
        }

        $data = $response->json();
        return $data['newsList'] ?? [];
    }

    /**
     * Save or update an article into posts table
     */
    protected function saveOrUpdateArticle(array $item, array &$stats): void
    {
        $seq = $item['seq'] ?? null;
        if (!$seq) {
            return;
        }

        $title = trim(html_entity_decode($item['title'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if (empty($title)) {
            return;
        }

        $metaDesc = trim(html_entity_decode($item['metaDescription'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $regDate = $item['reg_date'] ?? null;
        $publishedAt = $regDate ? Carbon::parse($regDate) : now();

        // Image URL
        $imagePath = $item['srcWeb'] ?? $item['srcTab'] ?? $item['srcMob'] ?? null;
        $imageUrl = $imagePath ? (Str::startsWith($imagePath, 'http') ? $imagePath : 'https://www.hyundai.com' . $imagePath) : null;

        // Source URL
        $sourceUrl = "https://www.hyundai.com/id/en/hyundai-story/news/detail?newsid={$seq}";

        // Category Classification
        $category = 'News';
        $titleUpper = strtoupper($title);
        if (Str::contains($titleUpper, ['GIIAS', 'EVENT', 'SUNDAY', 'GATHERING', 'FESTIVAL', 'EXHIBITION'])) {
            $category = 'Event';
        } elseif (Str::contains($titleUpper, ['PROMO', 'PRICING', 'PRICE', 'PENILAIAN', 'BENEFIT', 'OFFER', 'DISCOUNT'])) {
            $category = 'Promo';
        } elseif (Str::contains($titleUpper, ['TIPS', 'GUIDE', 'TECH', 'E-GMP', 'MAINTENANCE', 'CARE', 'BATTERY', 'SERVICE'])) {
            $category = 'Tips';
        } else {
            $category = 'News';
        }

        // Slug
        $baseSlug = Str::slug($title);
        $slug = $baseSlug ?: "hyundai-news-{$seq}";

        // Rich Content Format
        $richContent = $this->generateArticleContent($title, $metaDesc, $imageUrl, $sourceUrl, $publishedAt, $category);

        $existing = Post::where('seq', $seq)->first();

        if ($existing) {
            $existing->update([
                'title' => $title,
                'content' => $richContent,
                'image' => $imageUrl ?? $existing->image,
                'category' => $category,
                'source_url' => $sourceUrl,
                'source_name' => 'Hyundai Motors Indonesia',
                'published_at' => $publishedAt,
                'is_published' => true,
            ]);
            $stats['updated']++;
        } else {
            // Ensure unique slug
            if (Post::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . $seq;
            }

            Post::create([
                'seq' => $seq,
                'title' => $title,
                'slug' => $slug,
                'content' => $richContent,
                'image' => $imageUrl,
                'category' => $category,
                'source_url' => $sourceUrl,
                'source_name' => 'Hyundai Motors Indonesia',
                'published_at' => $publishedAt,
                'is_published' => true,
            ]);
            $stats['created']++;
        }
    }

    /**
     * Generate structured HTML content for the news
     */
    protected function generateArticleContent(string $title, string $metaDesc, ?string $imageUrl, string $sourceUrl, Carbon $publishedAt, string $category): string
    {
        $dateFormatted = $publishedAt->translatedFormat('d F Y');
        
        $html = '<div class="hyundai-official-article space-y-6">';
        
        // Official Release Badge
        $html .= '<div class="p-4 rounded-2xl bg-blue-50/80 border border-blue-200/80 flex items-center justify-between gap-4 text-xs">';
        $html .= '  <div class="flex items-center gap-2 text-[#002c5f] font-bold">';
        $html .= '    <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>';
        $html .= '    <span>Siaran Pers Resmi &bull; Hyundai Motors Indonesia</span>';
        $html .= '  </div>';
        $html .= '  <span class="text-gray-500 font-mono text-[11px]">' . $dateFormatted . '</span>';
        $html .= '</div>';

        // Lead Paragraph
        if (!empty($metaDesc)) {
            $html .= '<p class="text-lg leading-relaxed text-gray-800 font-medium border-l-4 border-[#002c5f] pl-4 italic bg-slate-50/50 py-2 rounded-r-xl">';
            $html .= e($metaDesc);
            $html .= '</p>';
        }

        // Article Body
        $html .= '<div class="text-gray-700 leading-relaxed text-base space-y-4">';
        $html .= '  <p><strong>SURABAYA, ' . $dateFormatted . '</strong> &ndash; ' . e($title) . ' menjadi salah satu komitmen berkelanjutan dari Hyundai dalam menghadirkan inovasi mobilitas terdepan serta pelayanan premium bagi masyarakat Indonesia.</p>';
        $html .= '  <p>' . (!empty($metaDesc) ? e($metaDesc) : 'Hyundai terus memperkuat posisi sebagai pelopor mobilitas masa depan di Indonesia dengan menghadirkan jajaran kendaraan inovatif, program layanan komprehensif, serta dukungan jaringan dealer resmi di berbagai kota besar termasuk wilayah Surabaya dan Jawa Timur.') . '</p>';
        $html .= '  <p>Melalui dealer resmi <strong>Hyundai Gowa HR Muhammad Surabaya</strong>, pelanggan di area Surabaya dan sekitarnya dapat menikmati seluruh benefit resmi, unit test drive lengkap, promo spesial, serta garansi resmi pabrikan.</p>';
        $html .= '</div>';

        // Official Source Link CTA
        $html .= '<div class="mt-8 p-6 rounded-3xl bg-gradient-to-r from-[#002c5f] to-[#004080] text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">';
        $html .= '  <div>';
        $html .= '    <h4 class="font-black text-sm uppercase tracking-wider text-cyan-300">Sumber Berita Resmi</h4>';
        $html .= '    <p class="text-xs text-blue-100 mt-1">Diterbitkan langsung oleh Hyundai Motors Indonesia (hyundai.com).</p>';
        $html .= '  </div>';
        $html .= '  <a href="' . e($sourceUrl) . '" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-black text-xs transition uppercase tracking-wider flex items-center gap-2 whitespace-nowrap shadow-md">';
        $html .= '    <span>Buka Rilis Asli</span>';
        $html .= '    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>';
        $html .= '  </a>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}
