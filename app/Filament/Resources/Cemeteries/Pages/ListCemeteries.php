<?php

namespace App\Filament\Resources\Cemeteries\Pages;

use App\Filament\Resources\Cemeteries\CemeteryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCemeteries extends ListRecords
{
    protected static string $resource = CemeteryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
