<?php

namespace App\Filament\Resources\ShowroomEventResource\Pages;

use App\Filament\Resources\ShowroomEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowroomEvent extends EditRecord
{
    protected static string $resource = ShowroomEventResource::class;

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
