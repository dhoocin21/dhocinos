<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Setting;
use App\Services\HyundaiNewsService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sync_hyundai')
                ->label('⚡ Tarik Berita Resmi Sekarang (Sync Hyundai.com)')
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
