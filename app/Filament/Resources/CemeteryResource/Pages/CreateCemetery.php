<?php

namespace App\Filament\Resources\CemeteryResource\Pages;

use App\Filament\Resources\CemeteryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCemetery extends CreateRecord
{
    protected static string $resource = CemeteryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
