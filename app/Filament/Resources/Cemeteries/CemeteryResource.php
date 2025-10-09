<?php

namespace App\Filament\Resources\Cemeteries;

use App\Filament\Resources\Cemeteries\Pages\CreateCemetery;
use App\Filament\Resources\Cemeteries\Pages\EditCemetery;
use App\Filament\Resources\Cemeteries\Pages\ListCemeteries;
use App\Filament\Resources\Cemeteries\Schemas\CemeteryForm;
use App\Filament\Resources\Cemeteries\Tables\CemeteriesTable;
use App\Models\Cemetery;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CemeteryResource extends Resource
{
    protected static ?string $model = Cemetery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Nghĩa trang';

    protected static ?string $modelLabel = 'Nghĩa trang';

    protected static ?string $pluralModelLabel = 'Nghĩa trang';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return CemeteryForm::configure($form);
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
