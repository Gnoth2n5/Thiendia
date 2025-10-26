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

                        Forms\Components\Select::make('commune')
                            ->label('Xã/Phường/Thị trấn')
                            ->options(function () {
                                // Gọi API để lấy danh sách communes
                                try {
                                    $controller = new \App\Http\Controllers\HomeController;
                                    $wards = $controller->fetchAndCacheWards();

                                    $options = [];
                                    foreach ($wards as $ward) {
                                        $options[$ward['name']] = "{$ward['type']} {$ward['name']}";
                                    }

                                    return $options;
                                } catch (\Exception $e) {
                                    Log::error('Error loading wards in Filament: ' . $e->getMessage());

                                    return [];
                                }
                            })
                            ->searchable()
                            ->placeholder('Chọn xã/phường/thị trấn')
                            ->helperText('Danh sách xã/phường từ API Ninh Bình'),

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
                Tables\Filters\SelectFilter::make('commune')
                    ->label('Xã/Phường')
                    ->options(function () {
                        try {
                            $controller = new \App\Http\Controllers\HomeController;
                            $wards = $controller->fetchAndCacheWards();

                            $options = [];
                            foreach ($wards as $ward) {
                                $options[$ward['name']] = "{$ward['type']} {$ward['name']}";
                            }

                            return $options;
                        } catch (\Exception $e) {
                            Log::error('Error loading wards in Filament filter: ' . $e->getMessage());

                            return [];
                        }
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
