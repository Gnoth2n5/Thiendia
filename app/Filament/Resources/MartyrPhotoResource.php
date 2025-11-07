<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MartyrPhotoResource\Pages;
use App\Models\Cemetery;
use App\Models\MartyrPhoto;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MartyrPhotoResource extends Resource
{
    protected static ?string $model = MartyrPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Ảnh liệt sĩ';

    protected static ?string $modelLabel = 'Ảnh';

    protected static ?string $pluralModelLabel = 'Ảnh liệt sĩ';

    protected static ?string $navigationGroup = 'Quản lý nội dung';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        // Nếu là cán bộ xã/phường, chỉ hiển thị ảnh của xã/phường mình
        /** @var User $user */
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
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin ảnh')
                    ->schema([
                        Forms\Components\Select::make('cemetery_id')
                            ->label('Nghĩa trang')
                            ->options(function () {
                                $query = Cemetery::query();

                                // Nếu là cán bộ xã/phường, chỉ hiển thị nghĩa trang của xã/phường mình
                                /** @var User $user */
                                $user = auth()->user();
                                if ($user && $user->isCommuneStaff()) {
                                    $query->where('commune', $user->commune);
                                }

                                return $query->pluck('name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Auto set commune khi chọn cemetery
                                if ($state) {
                                    $cemetery = Cemetery::find($state);
                                    if ($cemetery) {
                                        $set('commune_display', $cemetery->commune);
                                    }
                                }
                            })
                            ->disabled(fn (string $operation) => $operation === 'edit'),

                        Forms\Components\Placeholder::make('commune_display')
                            ->label('Xã/Phường')
                            ->content(function ($get, $record) {
                                if ($record && $record->cemetery) {
                                    return $record->cemetery->commune;
                                }

                                $cemeteryId = $get('cemetery_id');
                                if ($cemeteryId) {
                                    $cemetery = Cemetery::find($cemeteryId);

                                    return $cemetery?->commune ?? 'Chưa xác định';
                                }

                                return 'Chọn nghĩa trang';
                            })
                            ->helperText('Xã/Phường tự động theo nghĩa trang'),

                        // Upload nhiều ảnh khi tạo mới
                        Forms\Components\FileUpload::make('photos')
                            ->label('Ảnh liệt sĩ')
                            ->image()
                            ->multiple()
                            ->directory(function ($get) {
                                $cemeteryId = $get('cemetery_id');
                                if ($cemeteryId) {
                                    $cemetery = Cemetery::find($cemeteryId);
                                    if ($cemetery) {
                                        return MartyrPhoto::generateStoragePath($cemetery->commune);
                                    }
                                }

                                return 'martyr-photos/temp';
                            })
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn gọn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->reorderable()
                            ->appendFiles()
                            ->maxSize(10240)
                            ->maxFiles(500)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->required()
                            ->helperText('Kéo thả nhiều ảnh hoặc cả thư mục vào đây. Tối đa 500 ảnh, mỗi ảnh 10MB.')
                            ->columnSpanFull()
                            ->visible(fn (string $operation) => $operation === 'create'),

                        // Edit 1 ảnh khi sửa
                        Forms\Components\FileUpload::make('photo_single')
                            ->label('Ảnh')
                            ->image()
                            ->directory(function ($get, $record) {
                                if ($record && $record->cemetery) {
                                    return MartyrPhoto::generateStoragePath($record->cemetery->commune);
                                }

                                return 'martyr-photos/temp';
                            })
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn gọn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(10240)
                            ->required()
                            ->helperText('Thay đổi ảnh. Tối đa 10MB.')
                            ->columnSpanFull()
                            ->visible(fn (string $operation) => $operation === 'edit'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('Ảnh')
                    ->disk('public')
                    ->size(80)
                    ->square(),

                Tables\Columns\TextColumn::make('cemetery.name')
                    ->label('Nghĩa trang')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('cemetery.commune')
                    ->label('Xã/Phường')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('filename')
                    ->label('Tên file')
                    ->getStateUsing(fn (MartyrPhoto $record) => basename($record->photo_path))
                    ->copyable()
                    ->copyMessage('Đã copy tên file!')
                    ->copyMessageDuration(2000)
                    ->searchable(query: function ($query, $search) {
                        return $query->where('photo_path', 'like', "%{$search}%");
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Người upload')
                    ->sortable()
                    ->placeholder('Hệ thống')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày upload')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('cemetery_id')
                    ->label('Nghĩa trang')
                    ->relationship('cemetery', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('copyFilename')
                    ->label('Copy tên file')
                    ->icon('heroicon-o-clipboard-document')
                    ->color('gray')
                    ->action(function (MartyrPhoto $record) {
                        $filename = basename($record->photo_path);

                        // Hiển thị notification với tên file
                        \Filament\Notifications\Notification::make()
                            ->title('Tên file')
                            ->body($filename)
                            ->success()
                            ->persistent()
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('copy')
                                    ->label('Copy')
                                    ->button()
                                    ->close()
                                    ->extraAttributes([
                                        'x-on:click' => "
                                            navigator.clipboard.writeText('{$filename}');
                                            new FilamentNotification()
                                                .title('Đã copy!')
                                                .success()
                                                .send();
                                            close();
                                        ",
                                    ]),
                            ])
                            ->send();
                    }),
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
            'index' => Pages\ListMartyrPhotos::route('/'),
            'create' => Pages\CreateMartyrPhoto::route('/create'),
            'edit' => Pages\EditMartyrPhoto::route('/{record}/edit'),
        ];
    }
}
