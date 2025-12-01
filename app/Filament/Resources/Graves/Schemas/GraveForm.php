<?php

namespace App\Filament\Resources\Graves\Schemas;

use App\Models\Cemetery;
use App\Models\MartyrPhoto;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;

class GraveForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin nghĩa trang')
                    ->schema([
                        Select::make('cemetery_id')
                            ->label('Nghĩa trang an táng')
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
                            ->live(),

                        \Filament\Forms\Components\Hidden::make('plot_id')
                            ->dehydrated(true)
                            ->live(),

                        ViewField::make('plot_grid_simple')
                            ->label('Chọn lô mộ')
                            ->view('filament.forms.components.plot-grid-simple')
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Section::make('Thông tin liệt sĩ')
                    ->description('Thông tin về liệt sĩ an nghỉ tại lăng mộ')
                    ->schema([
                        TextInput::make('deceased_full_name')
                            ->label('Họ và tên liệt sỹ')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Họ và tên đầy đủ của liệt sỹ')
                            ->columnSpan(2),

                        TextInput::make('hometown')
                            ->label('Nguyên Quán')
                            ->maxLength(255)
                            ->placeholder('Quê quán của liệt sỹ')
                            ->columnSpan(2),

                        DatePicker::make('deceased_birth_date')
                            ->label('Ngày tháng năm sinh')
                            ->displayFormat('d/m/Y')
                            ->required(),

                        DatePicker::make('enlistment_date')
                            ->label('Ngày nhập ngũ')
                            ->displayFormat('d/m/Y')
                            ->helperText('Ngày tháng năm nhập ngũ'),

                        DatePicker::make('deceased_death_date')
                            ->label('Ngày tháng năm hy sinh')
                            ->displayFormat('d/m/Y')
                            ->required(),

                        TextInput::make('rank')
                            ->label('Cấp bậc')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Trung sĩ, Thượng sĩ, Đại úy...'),

                        TextInput::make('position')
                            ->label('Chức vụ')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Tiểu đội trưởng'),

                        TextInput::make('unit')
                            ->label('Đơn vị')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Tiểu đoàn 5, Trung đoàn 88...')
                            ->columnSpan(2),
                    ])
                    ->columns(3),

                Section::make('Hình ảnh')
                    ->schema([
                        FileUpload::make('deceased_photo')
                            ->label('Ảnh liệt sỹ')
                            ->image()
                            ->directory(function ($get, $record) {
                                // Lấy commune từ cemetery
                                $cemeteryId = $get('cemetery_id') ?? $record?->cemetery_id;
                                if ($cemeteryId) {
                                    $cemetery = Cemetery::find($cemeteryId);
                                    if ($cemetery) {
                                        return MartyrPhoto::generateStoragePath($cemetery->commune);
                                    }
                                }

                                return 'martyr-photos/temp';
                            })
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '4:5',
                                '3:4',
                            ])
                            ->maxSize(2048)
                            ->helperText('Ảnh dạng chữ nhật dọc (tối đa 2MB)'),

                        FileUpload::make('grave_photos')
                            ->label('Ảnh bia mộ')
                            ->image()
                            ->multiple()
                            ->directory(function ($get, $record) {
                                // Lấy commune từ cemetery
                                $cemeteryId = $get('cemetery_id') ?? $record?->cemetery_id;
                                if ($cemeteryId) {
                                    $cemetery = Cemetery::find($cemeteryId);
                                    if ($cemetery) {
                                        return MartyrPhoto::generateStoragePath($cemetery->commune);
                                    }
                                }

                                return 'martyr-photos/temp';
                            })
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(5)
                            ->maxSize(2048)
                            ->helperText('Tối đa 5 ảnh, mỗi ảnh tối đa 2MB'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Ghi chú')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Ghi chú')
                            ->rows(3)
                            ->placeholder('Ghi chú về tiểu sử, lịch sử hy sinh, công lao...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

            ]);
    }
}
