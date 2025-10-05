<?php

namespace App\Filament\Resources\Cemeteries;

use App\Filament\Resources\Cemeteries\Pages\CreateCemetery;
use App\Filament\Resources\Cemeteries\Pages\EditCemetery;
use App\Filament\Resources\Cemeteries\Pages\ListCemeteries;
use App\Filament\Resources\Cemeteries\Schemas\CemeteryForm;
use App\Filament\Resources\Cemeteries\Tables\CemeteriesTable;
use App\Models\Cemetery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CemeteryResource extends Resource
{
    protected static ?string $model = Cemetery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CemeteryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CemeteriesTable::configure($table);
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
            'index' => ListCemeteries::route('/'),
            'create' => CreateCemetery::route('/create'),
            'edit' => EditCemetery::route('/{record}/edit'),
        ];
    }
}