<?php

namespace App\Filament\Resources\ModificationRequests\Pages;

use App\Filament\Resources\ModificationRequests\ModificationRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateModificationRequest extends CreateRecord
{
    protected static string $resource = ModificationRequestResource::class;
}
