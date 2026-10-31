<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_csv')
                ->label('Ekspor ke Excel (CSV)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $fileName = 'leads-hyundai-surabaya-' . date('Y-m-d-His') . '.csv';
                    $leads = Lead::with('car')->latest()->get();

                    return response()->streamDownload(function () use ($leads) {
                        $handle = fopen('php://output', 'w');
                        // UTF-8 BOM for Excel compatibility
                        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                        
                        // Header Row
                        fputcsv($handle, [
                            'ID',
                            'Nama Customer',
                            'Nomor WhatsApp',
                            'Email',
                            'Unit Mobil Diminati',
                            'Rencana Pembelian',
                            'Status Follow-Up',
                            'Sumber Iklan (UTM)',
                            'Wilayah / Kota',
                            'Catatan Sales',
                            'Tanggal Masuk',
                        ]);

                        // Data Rows
                        foreach ($leads as $lead) {
                            fputcsv($handle, [
                                $lead->id,
                                $lead->name,
                                "'" . $lead->whatsapp,
                                $lead->email ?? '-',
                                $lead->car_name ?: ($lead->car?->name ?? 'Konsultasi'),
                                match($lead->purchase_type) {
                                    'credit' => 'Kredit',
                                    'cash' => 'Cash',
                                    'trade_in' => 'Tukar Tambah',
                                    default => $lead->purchase_type ?? '-'
                                },
                                match($lead->status) {
                                    'new' => 'Baru',
                                    'contacted' => 'Sudah Dihubungi',
                                    'prospect' => 'Prospek Serius',
                                    'test_drive' => 'Jadwal Test Drive',
                                    'spk' => 'SPK / Closing',
                                    'lost' => 'Batal',
                                    default => $lead->status
                                },
                                $lead->utm_source ?? 'Direct / Web',
                                $lead->region ?? 'Surabaya / Jatim',
                                $lead->notes ?? '-',
                                $lead->created_at?->format('d/m/Y H:i') ?? '-',
                            ]);
                        }

                        fclose($handle);
                    }, $fileName, [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                    ]);
                }),

            Actions\CreateAction::make()->label('Tambah Prospek Baru'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(Lead::count()),
            'new' => Tab::make('🔴 Baru')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(Lead::where('status', 'new')->count())
                ->badgeColor('danger'),
            'contacted' => Tab::make('🔵 Dihubungi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'contacted'))
                ->badge(Lead::where('status', 'contacted')->count())
                ->badgeColor('info'),
            'prospect' => Tab::make('🟡 Prospek Serius')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'prospect'))
                ->badge(Lead::where('status', 'prospect')->count())
                ->badgeColor('warning'),
            'test_drive' => Tab::make('🟣 Test Drive')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'test_drive'))
                ->badge(Lead::where('status', 'test_drive')->count()),
            'spk' => Tab::make('🟢 SPK / Closing')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'spk'))
                ->badge(Lead::where('status', 'spk')->count())
                ->badgeColor('success'),
        ];
    }
}
