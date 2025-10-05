<?php

namespace App\Filament\Resources\ModificationRequests\Pages;

use App\Filament\Resources\ModificationRequests\ModificationRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModificationRequests extends ListRecords
{
    protected static string $resource = ModificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
