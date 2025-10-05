<?php

namespace App\Filament\Resources\Cemeteries\Pages;

use App\Filament\Resources\Cemeteries\CemeteryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCemetery extends EditRecord
{
    protected static string $resource = CemeteryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
