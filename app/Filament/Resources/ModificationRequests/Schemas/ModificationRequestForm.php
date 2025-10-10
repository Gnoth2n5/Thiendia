<?php

namespace App\Filament\Resources\ModificationRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;

class ModificationRequestForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin người gửi yêu cầu')
                    ->schema([
                        Select::make('grave_id')
                            ->label('Lăng mộ')
                            ->relationship('grave', 'grave_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->cemetery->name} - {$record->grave_number} - {$record->owner_name}")
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record && $record->exists),

                        TextInput::make('requester_name')
                            ->label('Họ tên')
                            ->required()
                            ->disabled(fn ($record) => $record && $record->exists),

                        TextInput::make('requester_phone')
                            ->label('Số điện thoại')
                            ->required()
                            ->disabled(fn ($record) => $record && $record->exists),

                        TextInput::make('requester_email')
                            ->label('Email')
                            ->disabled(fn ($record) => $record && $record->exists),

                        TextInput::make('requester_relationship')
                            ->label('Mối quan hệ')
                            ->disabled(fn ($record) => $record && $record->exists),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('So sánh thông tin cần sửa')
                    ->description('Thông tin bên trái là dữ liệu hiện tại, bên phải là dữ liệu mới')
                    ->schema([
                        ViewField::make('requested_data_preview')
                            ->label('')
                            ->view('filament.forms.components.modification-request-preview'),
                    ])
                    ->visible(fn ($record) => $record && $record->exists),

                Section::make('Lý do yêu cầu')
                    ->schema([
                        Textarea::make('reason')
                            ->label('Lý do')
                            ->rows(3)
                            ->disabled(fn ($record) => $record && $record->exists)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record && $record->exists),

                Section::make('Kết quả xử lý')
                    ->schema([
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ xử lý',
                                'approved' => 'Đã phê duyệt',
                                'rejected' => 'Đã từ chối',
                            ])
                            ->disabled(),

                        DateTimePicker::make('processed_at')
                            ->label('Thời gian xử lý')
                            ->displayFormat('d/m/Y H:i')
                            ->disabled(),

                        Textarea::make('admin_notes')
                            ->label('Ghi chú admin')
                            ->rows(2)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record && $record->exists && $record->status !== 'pending'),
            ]);
    }
}
