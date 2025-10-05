<?php

namespace App\Filament\Resources\ModificationRequests\Pages;

use App\Filament\Resources\ModificationRequests\ModificationRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModificationRequest extends EditRecord
{
    protected static string $resource = ModificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
