<?php

namespace App\Filament\Resources\TradeInResource\Pages;

use App\Filament\Resources\TradeInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTradeIn extends EditRecord
{
    protected static string $resource = TradeInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
