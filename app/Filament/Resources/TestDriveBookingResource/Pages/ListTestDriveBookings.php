<?php

namespace App\Filament\Resources\TestDriveBookingResource\Pages;

use App\Filament\Resources\TestDriveBookingResource;
use App\Models\TestDriveBooking;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTestDriveBookings extends ListRecords
{
    protected static string $resource = TestDriveBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_csv')
                ->label('Ekspor ke Excel (CSV)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $fileName = 'test-drive-hyundai-' . date('Y-m-d-His') . '.csv';
                    $bookings = TestDriveBooking::with('car')->latest()->get();

                    return response()->streamDownload(function () use ($bookings) {
                        $handle = fopen('php://output', 'w');
                        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                        
                        fputcsv($handle, [
                            'ID',
                            'Nama Pemohon',
                            'Nomor WhatsApp',
                            'Email',
                            'Unit Mobil',
                            'Tanggal Jadwal',
                            'Jam',
                            'Lokasi Test Drive',
                            'Catatan',
                            'Waktu Pengajuan',
                        ]);

                        foreach ($bookings as $b) {
                            fputcsv($handle, [
                                $b->id,
                                $b->name,
                                "'" . $b->whatsapp,
                                $b->email ?? '-',
                                $b->car?->name ?? 'Semua Unit',
                                $b->preferred_date ? date('d/m/Y', strtotime($b->preferred_date)) : '-',
                                $b->preferred_time ?? '-',
                                $b->location ?? 'Showroom HR Muhammad',
                                $b->notes ?? '-',
                                $b->created_at?->format('d/m/Y H:i') ?? '-',
                            ]);
                        }

                        fclose($handle);
                    }, $fileName, [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                    ]);
                }),

            Actions\CreateAction::make()->label('Jadwalkan Test Drive'),
        ];
    }
}
