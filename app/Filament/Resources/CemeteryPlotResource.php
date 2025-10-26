<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CemeteryPlotResource\Pages;
use App\Models\Cemetery;
use App\Models\CemeteryPlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CemeteryPlotResource extends Resource
{
    protected static ?string $model = CemeteryPlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationLabel = 'Lô mộ';

    protected static ?string $modelLabel = 'Lô mộ';

    protected static ?string $pluralModelLabel = 'Lô mộ';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Quản lý nghĩa trang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin lô mộ')
                    ->schema([
                        Forms\Components\Select::make('cemetery_id')
                            ->label('Nghĩa trang')
                            ->options(Cemetery::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('plot_code')
                            ->label('Mã lô')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('VD: A1, B5, C10')
                            ->helperText('Mã định danh cho lô mộ'),

                        Forms\Components\TextInput::make('row')
                            ->label('Hàng')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('column')
                            ->label('Cột')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'available' => 'Còn trống',
                                'occupied' => 'Đã sử dụng',
                                'reserved' => 'Đã đặt trước',
                                'unavailable' => 'Không khả dụng',
                            ])
                            ->default('available')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Ghi chú')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cemetery.name')
                    ->label('Nghĩa trang')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('plot_code')
                    ->label('Mã lô')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('row')
                    ->label('Hàng')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('column')
                    ->label('Cột')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->colors([
                        'success' => 'available',
                        'danger' => 'occupied',
                        'warning' => 'reserved',
                        'secondary' => 'unavailable',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'available' => 'Còn trống',
                        'occupied' => 'Đã sử dụng',
                        'reserved' => 'Đã đặt trước',
                        'unavailable' => 'Không khả dụng',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('grave.deceased_full_name')
                    ->label('Liệt sĩ')
                    ->placeholder('—')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('cemetery_id')
                    ->label('Nghĩa trang')
                    ->relationship('cemetery', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'available' => 'Còn trống',
                        'occupied' => 'Đã sử dụng',
                        'reserved' => 'Đã đặt trước',
                        'unavailable' => 'Không khả dụng',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('plot_code');
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
            'index' => Pages\ListCemeteryPlots::route('/'),
            'create' => Pages\CreateCemeteryPlot::route('/create'),
            'view' => Pages\ViewCemeteryPlot::route('/{record}'),
            'edit' => Pages\EditCemeteryPlot::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->isAdmin() || $user->isCommuneStaff();
    }
}
