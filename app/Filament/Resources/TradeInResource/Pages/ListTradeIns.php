<?php

namespace App\Filament\Resources\TradeInResource\Pages;

use App\Filament\Resources\TradeInResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTradeIns extends ListRecords
{
    protected static string $resource = TradeInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Catat Pengajuan Tukar Tambah'),
        ];
    }
}
