<?php

namespace App\Filament\Resources\Graves\Pages;

use App\Filament\Resources\Graves\GraveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGrave extends EditRecord
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
