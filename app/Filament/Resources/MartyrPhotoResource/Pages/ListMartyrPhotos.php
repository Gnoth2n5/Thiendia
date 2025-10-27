<?php

namespace App\Filament\Resources\MartyrPhotoResource\Pages;

use App\Filament\Resources\MartyrPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMartyrPhotos extends ListRecords
{
    protected static string $resource = MartyrPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
