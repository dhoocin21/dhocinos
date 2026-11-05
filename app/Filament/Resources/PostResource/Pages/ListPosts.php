<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Car;
use App\Models\Post;
use App\Models\Setting;
use App\Services\AiService;
use App\Services\HyundaiNewsService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tulis Berita Manual')
                ->icon('heroicon-o-plus'),

            Actions\Action::make('generate_ai_article')
                ->label('🤖 Buat Artikel SEO Otomatis (AI)')
                ->icon('heroicon-o-sparkles')
                ->color('success')
                ->modalHeading('Generator Artikel SEO Otomatis (Gemini AI)')
                ->modalDescription('Hasilkan artikel 600-900 kata berstruktur rapi yang menargetkan kata kunci lokal Surabaya (Surabaya Barat, HR Muhammad, Sidoarjo, Gresik) dan langsung terindeks di Google.')
                ->modalSubmitActionLabel('⚡ Mulai Buat Artikel SEO')
                ->form([
                    Forms\Components\TextInput::make('topic')
                        ->label('Topik / Rencana Pembahasan')
                        ->placeholder('Contoh: Panduan Memilih Hyundai Creta vs Honda HR-V untuk Jalanan Surabaya')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('car_model')
                        ->label('Fokus Model Mobil (Opsional)')
                        ->options(fn () => Car::pluck('name', 'name')->toArray())
                        ->searchable()
                        ->placeholder('Pilih model yang ditonjolkan')
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('target_audience')
                        ->label('Target Pembaca')
                        ->default('Keluarga Muda & Profesional di Surabaya & Sidoarjo')
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('keywords')
                        ->label('Target Kata Kunci SEO Google')
                        ->default('Promo Hyundai Surabaya 2026, Dealer Hyundai HR Muhammad, Kredit Murah Surabaya, Test Drive')
                        ->columnSpanFull(),
                ])
                ->action(function (array $data, AiService $aiService) {
                    $result = $aiService->generateSeoArticle(
                        $data['topic'],
                        $data['car_model'] ?? null,
                        $data['target_audience'] ?? null,
                        $data['keywords'] ?? null
                    );

                    $car = !empty($data['car_model']) ? Car::where('name', $data['car_model'])->first() : null;
                    $image = $car?->image ?: 'https://www.hyundai.com/content/dam/hyundai/id/id/images/local/HYU_Logo_Vertical_Blue_RGB.png';

                    $slug = Str::slug($result['title']);
                    if (Post::where('slug', $slug)->exists()) {
                        $slug .= '-' . time();
                    }

                    $post = Post::create([
                        'title' => $result['title'],
                        'slug' => $slug,
                        'category' => $result['category'] ?? 'Tips',
                        'content' => $result['content'],
                        'image' => $image,
                        'source_name' => 'Hyundai Showroom Editorial (AI SEO)',
                        'source_url' => url('/'),
                        'is_published' => true,
                        'published_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Artikel SEO Berhasil Dibuat!')
                        ->body("Artikel '{$post->title}' telah terbit dan siap bersaing di halaman #1 Google!")
                        ->actions([
                            NotificationAction::make('view')
                                ->label('Lihat di Website')
                                ->url(route('posts.show', $post->slug))
                                ->openUrlInNewTab(),
                            NotificationAction::make('edit')
                                ->label('Edit')
                                ->url(PostResource::getUrl('edit', ['record' => $post])),
                        ])
                        ->success()
                        ->send();
                }),

            Actions\Action::make('sync_hyundai')
                ->label('⚡ Tarik Berita Hyundai.com')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Tarik Berita Resmi dari Hyundai Indonesia')
                ->modalDescription('Sistem akan menghubungi server hyundai.com dan memperbarui berita, siaran pers, foto resolusi tinggi, serta rilis produk terbaru ke portal web Anda secara otomatis.')
                ->modalSubmitActionLabel('Mulai Tarik Berita')
                ->action(function (HyundaiNewsService $service) {
                    $stats = $service->syncNews(20);

                    if (isset($stats['error_message'])) {
                        Notification::make()
                            ->title('Gagal Sinkronisasi')
                            ->body($stats['error_message'])
                            ->danger()
                            ->send();
                        return;
                    }

                    Notification::make()
                        ->title('Sinkronisasi Berhasil!')
                        ->body("Berhasil memeriksa {$stats['total_fetched']} berita resmi dari hyundai.com. (Baru: {$stats['created']}, Diperbarui: {$stats['updated']})")
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getSubheading(): ?string
    {
        $lastSync = Setting::get('hyundai_news_last_synced_at');
        $timeStr = $lastSync ? \Carbon\Carbon::parse($lastSync)->translatedFormat('d M Y, H:i') . ' WIB' : 'Belum pernah';
        return "Berita terhubung secara otomatis ke sumber resmi: https://www.hyundai.com/id/en/hyundai-story/news (Terakhir sinkronisasi: {$timeStr})";
    }
}
