<?php

namespace App\Filament\Resources\ShowroomEventResource\Pages;

use App\Filament\Resources\ShowroomEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShowroomEvent extends CreateRecord
{
    protected static string $resource = ShowroomEventResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
