<?php

namespace App\Filament\Resources\ModificationRequests;

use App\Filament\Resources\ModificationRequests\Pages\CreateModificationRequest;
use App\Filament\Resources\ModificationRequests\Pages\EditModificationRequest;
use App\Filament\Resources\ModificationRequests\Pages\ListModificationRequests;
use App\Filament\Resources\ModificationRequests\Schemas\ModificationRequestForm;
use App\Filament\Resources\ModificationRequests\Tables\ModificationRequestsTable;
use App\Models\ModificationRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ModificationRequestResource extends Resource
{
    protected static ?string $model = ModificationRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ModificationRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModificationRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModificationRequests::route('/'),
            'create' => CreateModificationRequest::route('/create'),
            'edit' => EditModificationRequest::route('/{record}/edit'),
        ];
    }
}
