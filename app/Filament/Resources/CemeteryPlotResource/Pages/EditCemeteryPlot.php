<?php

namespace App\Filament\Resources\CemeteryPlotResource\Pages;

use App\Filament\Resources\CemeteryPlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCemeteryPlot extends EditRecord
{
    protected static string $resource = CemeteryPlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
