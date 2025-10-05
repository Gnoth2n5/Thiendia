<?php

namespace App\Filament\Resources\Graves;

use App\Filament\Resources\Graves\Pages\CreateGrave;
use App\Filament\Resources\Graves\Pages\EditGrave;
use App\Filament\Resources\Graves\Pages\ListGraves;
use App\Filament\Resources\Graves\Schemas\GraveForm;
use App\Filament\Resources\Graves\Tables\GravesTable;
use App\Models\Grave;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GraveResource extends Resource
{
    protected static ?string $model = Grave::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Lăng mộ';

    protected static ?string $modelLabel = 'Lăng mộ';

    protected static ?string $pluralModelLabel = 'Lăng mộ';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return GraveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GravesTable::configure($table);
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
            'index' => ListGraves::route('/'),
            'create' => CreateGrave::route('/create'),
            'edit' => EditGrave::route('/{record}/edit'),
        ];
    }
}
