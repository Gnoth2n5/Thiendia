<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Người dùng';

    protected static ?string $modelLabel = 'Người dùng';

    protected static ?string $pluralModelLabel = 'Người dùng';

    protected static ?string $navigationGroup = 'Quản lý hệ thống';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin tài khoản')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Họ và tên')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => \Illuminate\Support\Facades\Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText('Để trống nếu không muốn thay đổi mật khẩu'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Phân quyền')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->label('Vai trò')
                            ->options([
                                'admin' => 'Quản trị viên',
                                'commune_staff' => 'Cán bộ xã/phường',
                                'viewer' => 'Người xem',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== 'commune_staff') {
                                    $set('commune', null);
                                }
                            }),

                        Forms\Components\Select::make('commune')
                            ->label('Xã/Phường quản lý')
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
                                    \Illuminate\Support\Facades\Log::error('Error loading wards in UserResource: ' . $e->getMessage());

                                    return [];
                                }
                            })
                            ->searchable()
                            ->placeholder('Chọn xã/phường')
                            ->helperText('Chỉ áp dụng cho vai trò Cán bộ xã/phường')
                            ->visible(fn(callable $get) => $get('role') === 'commune_staff')
                            ->required(fn(callable $get) => $get('role') === 'commune_staff'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Họ và tên')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('role')
                    ->label('Vai trò')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin', 'super_admin' => 'Quản trị viên',
                        'commune_staff' => 'Cán bộ xã/phường',
                        'viewer' => 'Người xem',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'commune_staff',
                        'success' => 'viewer',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('commune')
                    ->label('Xã/Phường')
                    ->searchable()
                    ->sortable()
                    ->default('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Vai trò')
                    ->options([
                        'admin' => 'Quản trị viên',
                        'commune_staff' => 'Cán bộ xã/phường',
                        'viewer' => 'Người xem',
                    ]),

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
                            \Illuminate\Support\Facades\Log::error('Error loading wards in UserResource filter: ' . $e->getMessage());

                            return [];
                        }
                    })
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (User $record) {
                        $currentUser = auth()->user();

                        return $currentUser->isAdmin() && $record->id !== $currentUser->id;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(function () {
                            return auth()->user()->isAdmin();
                        }),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $currentUser = auth()->user();

        return $currentUser && $currentUser->isAdmin();
    }
}
