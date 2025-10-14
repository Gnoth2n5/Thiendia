<?php

namespace App\Filament\Resources\Graves\Schemas;

use App\Models\Cemetery;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
                Section::make('Thông tin cơ bản')
                    ->schema([
                        Select::make('cemetery_id')
                            ->label('Nghĩa trang')
                            ->options(Cemetery::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, $context) {
                                // Chỉ tự động generate khi tạo mới
                                if ($context === 'create' && $state) {
                                    $nextNumber = \App\Models\Grave::where('cemetery_id', $state)->count() + 1;
                                    $graveNumber = $state.'-'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                                    $set('grave_number', $graveNumber);
                                }
                            }),

                        Placeholder::make('grave_number_preview')
                            ->label('Số lăng mộ (tự động)')
                            ->content(function ($get, $record) {
                                if ($record?->grave_number) {
                                    return $record->grave_number;
                                }

                                $cemeteryId = $get('cemetery_id');
                                if ($cemeteryId) {
                                    return \App\Models\Grave::generateGraveNumber($cemeteryId);
                                }

                                return 'Chọn nghĩa trang để xem số lăng mộ';
                            })
                            ->visible(fn ($context) => $context === 'create'),

                        TextInput::make('grave_number')
                            ->label('Số lăng mộ')
                            ->disabled()
                            ->dehydrated()
                            ->visible(fn ($context) => $context === 'edit'),

                        TextInput::make('owner_name')
                            ->label('Tên chủ lăng mộ')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('burial_date')
                            ->label('Ngày an táng')
                            ->displayFormat('d/m/Y'),

                        Select::make('grave_type')
                            ->label('Loại lăng mộ')
                            ->options([
                                'đất' => 'Lăng mộ đất',
                                'xi_măng' => 'Lăng mộ xi măng',
                                'đá' => 'Lăng mộ đá',
                                'gỗ' => 'Lăng mộ gỗ',
                                'khác' => 'Loại khác',
                            ])
                            ->default('đất')
                            ->required(),

                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'còn_trống' => 'Còn trống',
                                'đã_sử_dụng' => 'Đã sử dụng',
                                'bảo_trì' => 'Bảo trì',
                                'ngừng_sử_dụng' => 'Ngừng sử dụng',
                            ])
                            ->default('còn_trống')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Thông tin người đã khuất')
                    ->schema([
                        TextInput::make('deceased_full_name')
                            ->label('Họ tên đầy đủ')
                            ->maxLength(255)
                            ->placeholder('Họ và tên người đã khuất'),

                        DatePicker::make('deceased_birth_date')
                            ->label('Ngày sinh')
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('deceased_death_date')
                            ->label('Ngày mất')
                            ->displayFormat('d/m/Y'),

                        Select::make('deceased_gender')
                            ->label('Giới tính')
                            ->options([
                                'nam' => 'Nam',
                                'nữ' => 'Nữ',
                                'khác' => 'Khác',
                            ])
                            ->default('nam'),

                        TextInput::make('deceased_relationship')
                            ->label('Mối quan hệ với chủ lăng mộ')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: cha, mẹ, ông, bà...'),

                        FileUpload::make('deceased_photo')
                            ->label('Ảnh người đã khuất')
                            ->image()
                            ->directory('deceased-photos')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '4:5',
                                '3:4',
                            ])
                            ->maxSize(2048)
                            ->helperText('Ảnh dạng chữ nhật dọc (tối đa 2MB)'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Hình ảnh bia mộ')
                    ->schema([
                        FileUpload::make('grave_photos')
                            ->label('Ảnh bia mộ')
                            ->image()
                            ->multiple()
                            ->directory('grave-photos')
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(5)
                            ->maxSize(2048)
                            ->helperText('Tối đa 5 ảnh, mỗi ảnh tối đa 2MB'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Thông tin bổ sung')
                    ->schema([
                        Textarea::make('location_description')
                            ->label('Mô tả vị trí')
                            ->rows(2)
                            ->placeholder('Ví dụ: Khu A, hàng 3, mộ số 15'),

                        Textarea::make('notes')
                            ->label('Ghi chú')
                            ->rows(2)
                            ->placeholder('Ghi chú thêm về lăng mộ...'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Vị trí trên bản đồ')
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Vĩ độ (Latitude)')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('20.250600')
                            ->live()
                            ->helperText('Tọa độ vĩ độ GPS'),

                        TextInput::make('longitude')
                            ->label('Kinh độ (Longitude)')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('105.974500')
                            ->live()
                            ->helperText('Tọa độ kinh độ GPS'),

                        ViewField::make('map_picker')
                            ->view('filament.forms.components.map-picker')
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Thông tin liên hệ')
                    ->schema([
                        TextInput::make('contact_info.phone')
                            ->label('Số điện thoại')
                            ->tel()
                            ->placeholder('0912345678'),

                        TextInput::make('contact_info.email')
                            ->label('Email')
                            ->email()
                            ->placeholder('email@example.com'),

                        TextInput::make('contact_info.address')
                            ->label('Địa chỉ liên hệ')
                            ->placeholder('Địa chỉ để liên lạc')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

            ]);
    }
}
