<?php

namespace App\Filament\Resources\TradeInResource\Pages;

use App\Filament\Resources\TradeInResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTradeIn extends CreateRecord
{
    protected static string $resource = TradeInResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
