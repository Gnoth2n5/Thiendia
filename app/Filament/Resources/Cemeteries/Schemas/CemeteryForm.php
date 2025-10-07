<?php

namespace App\Filament\Resources\Cemeteries\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class CemeteryForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin nghĩa trang')
                    ->description('Nhập thông tin cơ bản về nghĩa trang')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên nghĩa trang')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Nghĩa trang Bình Hưng Hòa'),

                        Textarea::make('address')
                            ->label('Địa chỉ')
                            ->required()
                            ->rows(3)
                            ->placeholder('Nhập địa chỉ đầy đủ của nghĩa trang'),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(4)
                            ->placeholder('Mô tả về nghĩa trang, dịch vụ, đặc điểm...'),
                    ])
                    ->columns(1),
            ]);
    }
}
