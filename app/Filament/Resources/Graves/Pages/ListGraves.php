<?php

namespace App\Filament\Resources\Graves\Pages;

use App\Filament\Resources\Graves\GraveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGraves extends ListRecords
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
