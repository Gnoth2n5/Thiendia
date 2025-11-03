<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSettingResource\Pages;
use App\Models\ContactSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSettingResource extends Resource
{
    protected static ?string $model = ContactSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Cài đặt liên hệ';

    protected static ?string $modelLabel = 'Cài đặt liên hệ';

    protected static ?string $pluralModelLabel = 'Cài đặt liên hệ';

    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin liên hệ')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Số điện thoại hotline')
                            ->placeholder('Ví dụ: 1900-xxxx')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone_description')
                            ->label('Mô tả cho số điện thoại')
                            ->placeholder('Ví dụ: Hỗ trợ tra cứu và tư vấn 24/7')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email hỗ trợ')
                            ->email()
                            ->placeholder('Ví dụ: contact@example.com')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email_description')
                            ->label('Mô tả cho email')
                            ->placeholder('Ví dụ: Phản hồi trong vòng 24 giờ')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address_line1')
                            ->label('Địa chỉ dòng 1')
                            ->placeholder('Ví dụ: Số 123, Đường ABC, Phường XYZ')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address_line2')
                            ->label('Địa chỉ dòng 2')
                            ->placeholder('Ví dụ: Thành phố Ninh Bình, Tỉnh Ninh Bình')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address_description')
                            ->label('Mô tả cho địa chỉ')
                            ->placeholder('Ví dụ: Giờ làm việc: 8:00 - 17:00 (T2-T6)')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Giờ làm việc')
                    ->schema([
                        Forms\Components\Repeater::make('working_hours')
                            ->label('Giờ làm việc')
                            ->schema([
                                Forms\Components\TextInput::make('day')
                                    ->label('Thứ')
                                    ->placeholder('Ví dụ: Thứ 2 - Thứ 6')
                                    ->required()
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('hours')
                                    ->label('Giờ')
                                    ->placeholder('Ví dụ: 8:00 - 17:00')
                                    ->required()
                                    ->maxLength(100),

                                Forms\Components\Toggle::make('is_closed')
                                    ->label('Nghỉ')
                                    ->default(false),
                            ])
                            ->defaultItems(4)
                            ->addActionLabel('Thêm giờ làm việc')
                            ->collapsible(),

                        Forms\Components\Textarea::make('note')
                            ->label('Ghi chú')
                            ->placeholder('Ghi chú bổ sung')
                            ->rows(3),
                    ]),

                Forms\Components\Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->default(true)
                    ->helperText('Chỉ thiết lập đang kích hoạt mới được hiển thị trên trang contact'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->label('Hotline')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address_line1')
                    ->label('Địa chỉ')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Kích hoạt')
                    ->boolean()
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái')
                    ->placeholder('Tất cả')
                    ->trueLabel('Đang kích hoạt')
                    ->falseLabel('Không kích hoạt'),
            ])
            ->actions([
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
            'index' => Pages\ListContactSettings::route('/'),
            'create' => Pages\CreateContactSetting::route('/create'),
            'edit' => Pages\EditContactSetting::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Chỉ cho phép admin truy cập cài đặt liên hệ
        return $user->isAdmin();
    }

    public static function shouldRegisterNavigation(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Chỉ hiển thị menu cho admin
        return $user->isAdmin();
    }
}
