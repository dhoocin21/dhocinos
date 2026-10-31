<?php

namespace App\Filament\Resources\ShowroomEventResource\Pages;

use App\Filament\Resources\ShowroomEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShowroomEvents extends ListRecords
{
    protected static string $resource = ShowroomEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Jadwal Event Showroom'),
        ];
    }
}
