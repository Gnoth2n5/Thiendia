<?php

namespace App\Filament\Resources\ModificationRequests;

use App\Filament\Resources\ModificationRequests\Pages\ListModificationRequests;
use App\Filament\Resources\ModificationRequests\Schemas\ModificationRequestForm;
use App\Filament\Resources\ModificationRequests\Tables\ModificationRequestsTable;
use App\Models\ModificationRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ModificationRequestResource extends Resource
{
    protected static ?string $model = ModificationRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Đơn yêu cầu';

    protected static ?string $modelLabel = 'Đơn yêu cầu';

    protected static ?string $pluralModelLabel = 'Đơn yêu cầu sửa đổi';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return ModificationRequestForm::configure($form);
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
            'view' => Pages\ViewModificationRequest::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
