<?php

namespace App\Filament\Resources\Graves;

use App\Filament\Resources\Graves\Pages\CreateGrave;
use App\Filament\Resources\Graves\Pages\EditGrave;
use App\Filament\Resources\Graves\Pages\ListGraves;
use App\Filament\Resources\Graves\Schemas\GraveForm;
use App\Filament\Resources\Graves\Tables\GravesTable;
use App\Models\Grave;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class GraveResource extends Resource
{
    protected static ?string $model = Grave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Lăng mộ';

    protected static ?string $modelLabel = 'Lăng mộ';

    protected static ?string $pluralModelLabel = 'Lăng mộ';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        // Nếu là cán bộ xã/phường, chỉ hiển thị lăng mộ của xã/phường mình
        $user = auth()->user();
        if ($user && $user->isCommuneStaff()) {
            $query->whereHas('cemetery', function ($q) use ($user) {
                $q->where('commune', $user->commune);
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return GraveForm::configure($form);
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
