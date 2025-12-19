<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Cài đặt';

    protected static ?string $modelLabel = 'Cài đặt';

    protected static ?string $pluralModelLabel = 'Cài đặt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin cài đặt')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Khóa')
                            ->disabled()
                            ->dehydrated() // Đảm bảo key vẫn được gửi trong form data
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Ví dụ: banner, site_name, etc.')
                            ->helperText('Khóa định danh duy nhất cho setting'),

                        Forms\Components\Toggle::make('status')
                            ->label('Trạng thái')
                            ->default(true)
                            ->helperText('Bật/tắt setting'),

                        Forms\Components\Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(2)
                            ->placeholder('Mô tả về setting này')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Giá trị')
                    ->schema([
                        Forms\Components\FileUpload::make('banner_images')
                            ->label('Ảnh banner')
                            ->image()
                            ->multiple()
                            ->directory('banners')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '21:9',
                                null,
                            ])
                            ->reorderable()
                            ->maxFiles(10)
                            ->maxSize(5120)
                            ->helperText('Tối đa 10 ảnh, mỗi ảnh tối đa 5MB. Tỷ lệ khuyến nghị: 16:9 hoặc 21:9')
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('key') === 'banner')
                            ->dehydrated(true),

                        Forms\Components\Hidden::make('value')
                            ->default('')
                            ->dehydrated(),

                        Forms\Components\Textarea::make('value_text')
                            ->label('Giá trị')
                            ->rows(4)
                            ->placeholder('Nhập giá trị setting (có thể là JSON, text, etc.)')
                            ->helperText('Đối với banner, sử dụng FileUpload ở trên')
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('key') !== 'banner')
                            ->required(fn ($get) => $get('key') !== 'banner')
                            ->dehydrated(false)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('value', $state ?? '');
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Khóa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Giá trị')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    })
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Trạng thái')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 30 ? $state : null;
                    })
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        true => 'Đang bật',
                        false => 'Đang tắt',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
