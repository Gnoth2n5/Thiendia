<?php

namespace App\Filament\Resources\CemeteryResource\Pages;

use App\Filament\Resources\CemeteryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCemetery extends ViewRecord
{
    protected static string $resource = CemeteryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
