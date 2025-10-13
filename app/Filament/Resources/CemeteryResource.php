<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CemeteryResource\Pages;
use App\Models\Cemetery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;


class CemeteryResource extends Resource
{
    protected static ?string $model = Cemetery::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Nghĩa trang';

    protected static ?string $modelLabel = 'Nghĩa trang';

    protected static ?string $pluralModelLabel = 'Nghĩa trang';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin nghĩa trang')
                    ->description('Nhập thông tin cơ bản về nghĩa trang')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên nghĩa trang')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Nghĩa trang Bình Hưng Hòa'),

                        Forms\Components\Select::make('district')
                            ->label('Huyện/Thành phố')
                            ->options(function () {
                                $locations = config('ninhbinh_locations');

                                return array_combine(
                                    array_keys($locations),
                                    array_keys($locations)
                                );
                            })
                            ->searchable()
                            ->live() // Try live() for compatibility with this Filament/Livewire version
                            // afterStateUpdated receives ($state, $set)
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Clear commune when district changes
                                $set('commune', null);
                            })
                            ->placeholder('Chọn huyện/thành phố'),

                        Forms\Components\Select::make('commune')
                            ->label('Xã/Phường/Thị trấn')
                            ->options(function (callable $get) {
                                $district = $get('district');

                                if (empty($district)) {
                                    return [];
                                }

                                $locations = config('ninhbinh_locations');
                                if (!is_array($locations)) {
                                    // Log::warning('ninhbinh_locations config is not an array', ['locations' => $locations]);
                                    return [];
                                }

                                $communes = $locations[$district] ?? [];

                                if (!is_array($communes) || empty($communes)) {
                                    // Log::debug("No communes found for district {$district}", ['communes' => $communes]);
                                    return [];
                                }

                                // Log::debug("Cemeteries communes for district {$district}", ['communes' => $communes]);

                                return array_combine(array_values($communes), array_values($communes));
                            })
                            // ->searchable()
                            ->disabled(fn(callable $get) => empty($get('district')))
                            ->placeholder('Chọn xã/phường/thị trấn')
                            ->helperText(function (callable $get) {
                                $district = $get('district');

                                if (empty($district)) {
                                    return 'Chưa chọn huyện/thành phố';
                                }

                                $locations = config('ninhbinh_locations');
                                if (!is_array($locations)) {
                                    return 'Config locations không hợp lệ';
                                }

                                $communes = $locations[$district] ?? [];
                                $count = is_array($communes) ? count($communes) : 0;

                                return "Tìm thấy {$count} xã/phường cho \"{$district}\"";
                            })
                            ->live(), // try live() instead of reactive()


                        Forms\Components\Textarea::make('address')
                            ->label('Địa chỉ chi tiết')
                            ->required()
                            ->rows(3)
                            ->placeholder('Nhập địa chỉ đầy đủ của nghĩa trang'),

                        Forms\Components\Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(4)
                            ->placeholder('Mô tả về nghĩa trang, dịch vụ, đặc điểm...'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên nghĩa trang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('district')
                    ->label('Huyện/Thành phố')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('commune')
                    ->label('Xã/Phường')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Địa chỉ')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('graves_count')
                    ->label('Số lăng mộ')
                    ->counts('graves')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('district')
                    ->label('Huyện/Thành phố')
                    ->options(function () {
                        $locations = config('ninhbinh_locations');

                        return array_combine(
                            array_keys($locations),
                            array_keys($locations)
                        );
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('commune')
                    ->label('Xã/Phường')
                    ->options(function () {
                        $locations = config('ninhbinh_locations');
                        $allCommunes = [];
                        foreach ($locations as $district => $communes) {
                            foreach ($communes as $commune) {
                                $allCommunes[$commune] = $commune;
                            }
                        }

                        return $allCommunes;
                    })
                    ->searchable(),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCemeteries::route('/'),
            'create' => Pages\CreateCemetery::route('/create'),
            'view' => Pages\ViewCemetery::route('/{record}'),
            'edit' => Pages\EditCemetery::route('/{record}/edit'),
        ];
    }
}
