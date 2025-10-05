<?php

namespace App\Filament\Resources\Graves\Schemas;

use App\Models\Cemetery;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GraveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cơ bản')
                    ->description('Thông tin chính về lăng mộ')
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
                                    $graveNumber = $state . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
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
                            ->visible(fn($context) => $context === 'create'),

                        TextInput::make('grave_number')
                            ->label('Số lăng mộ')
                            ->disabled()
                            ->dehydrated()
                            ->visible(fn($context) => $context === 'edit'),

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
                    ->description('Thông tin về người đã được an táng')
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
                                '1:1',
                                '4:3',
                            ])
                            ->maxSize(5120)
                            ->helperText('Tải lên ảnh người đã khuất (tối đa 5MB)'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Hình ảnh bia mộ')
                    ->description('Ảnh trạng thái hiện tại của bia mộ')
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
                            ->maxSize(5120)
                            ->helperText('Tải lên tối đa 5 ảnh bia mộ (mỗi ảnh tối đa 5MB)'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Thông tin vị trí và liên hệ')
                    ->schema([
                        Textarea::make('location_description')
                            ->label('Mô tả vị trí')
                            ->rows(3)
                            ->placeholder('Mô tả vị trí cụ thể trong nghĩa trang...'),

                        KeyValue::make('contact_info')
                            ->label('Thông tin liên hệ')
                            ->keyLabel('Loại thông tin')
                            ->valueLabel('Nội dung')
                            ->addActionLabel('Thêm thông tin liên hệ')
                            ->default([
                                'phone' => '',
                                'address' => '',
                                'email' => '',
                            ]),

                        Textarea::make('notes')
                            ->label('Ghi chú')
                            ->rows(3)
                            ->placeholder('Ghi chú thêm về lăng mộ...'),
                    ])
                    ->columns(1),

            ]);
    }
}