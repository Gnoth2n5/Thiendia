<?php

namespace App\Filament\Resources\ModificationRequests\Schemas;

use App\Models\Grave;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class ModificationRequestForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin đơn yêu cầu')
                    ->description('Thông tin cơ bản về đơn yêu cầu sửa đổi')
                    ->schema([
                        Select::make('grave_id')
                            ->label('Lăng mộ')
                            ->options(Grave::with('cemetery')->get()->mapWithKeys(function ($grave) {
                                return [$grave->id => "{$grave->cemetery->name} - {$grave->grave_number} ({$grave->owner_name})"];
                            }))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('request_type')
                            ->label('Loại yêu cầu')
                            ->options([
                                'sửa_thông_tin' => 'Sửa thông tin',
                                'thêm_người' => 'Thêm người',
                                'xóa_người' => 'Xóa người',
                                'sửa_vị_trí' => 'Sửa vị trí',
                                'khác' => 'Khác',
                            ])
                            ->required(),

                        Textarea::make('reason')
                            ->label('Lý do yêu cầu')
                            ->required()
                            ->rows(3)
                            ->placeholder('Mô tả chi tiết lý do yêu cầu sửa đổi...'),
                    ])
                    ->columns(1),

                Section::make('Thông tin người yêu cầu')
                    ->description('Thông tin liên hệ của người gửi đơn yêu cầu')
                    ->schema([
                        TextInput::make('requester_name')
                            ->label('Tên người yêu cầu')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('requester_phone')
                            ->label('Số điện thoại')
                            ->required()
                            ->tel()
                            ->maxLength(20),

                        TextInput::make('requester_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('requester_relationship')
                            ->label('Mối quan hệ với người đã khuất')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: con, cháu, vợ/chồng...'),
                    ])
                    ->columns(2),

                Section::make('Dữ liệu hiện tại')
                    ->description('Thông tin hiện tại của lăng mộ (chỉ đọc)')
                    ->schema([
                        KeyValue::make('current_data')
                            ->label('Dữ liệu hiện tại')
                            ->keyLabel('Trường')
                            ->valueLabel('Giá trị')
                            ->disabled()
                            ->default([]),
                    ])
                    ->collapsible(),

                Section::make('Dữ liệu yêu cầu sửa đổi')
                    ->description('Thông tin mới mà người yêu cầu muốn thay đổi')
                    ->schema([
                        KeyValue::make('requested_data')
                            ->label('Dữ liệu yêu cầu sửa đổi')
                            ->keyLabel('Trường')
                            ->valueLabel('Giá trị mới')
                            ->addActionLabel('Thêm trường dữ liệu')
                            ->required(),
                    ])
                    ->collapsible(),

                Section::make('Xử lý đơn yêu cầu')
                    ->description('Phần dành cho admin xử lý đơn yêu cầu')
                    ->schema([
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ xử lý',
                                'approved' => 'Đã phê duyệt',
                                'rejected' => 'Đã từ chối',
                            ])
                            ->default('pending')
                            ->required(),

                        Textarea::make('admin_notes')
                            ->label('Ghi chú của admin')
                            ->rows(3)
                            ->placeholder('Ghi chú về quá trình xử lý đơn yêu cầu...'),

                        DateTimePicker::make('processed_at')
                            ->label('Thời gian xử lý')
                            ->default(now())
                            ->displayFormat('d/m/Y H:i'),
                    ])
                    ->columns(1)
                    ->visible(fn ($record) => $record && $record->exists),
            ]);
    }
}
