<?php

namespace App\Filament\Resources\CemeteryPlotResource\Pages;

use App\Filament\Resources\CemeteryPlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCemeteryPlot extends ViewRecord
{
    protected static string $resource = CemeteryPlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
