<?php

namespace App\Filament\Resources\Cemeteries\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

                        Select::make('district')
                            ->label('Huyện/Thành phố')
                            ->options(array_combine(
                                array_keys(config('ninhbinh_locations')),
                                array_keys(config('ninhbinh_locations'))
                            ))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn(callable $set) => $set('commune', null))
                            ->placeholder('Chọn huyện/thành phố'),

                        Select::make('commune')
                            ->label('Xã/Phường/Thị trấn')
                            ->options(function (callable $get) {
                                $district = $get('district');
                                if (! $district) {
                                    return [];
                                }
                                $communes = config("ninhbinh_locations.{$district}", []);

                                return array_combine($communes, $communes);
                            })
                            ->searchable()
                            ->disabled(fn(callable $get) => ! $get('district'))
                            ->placeholder('Chọn xã/phường/thị trấn'),

                        Textarea::make('address')
                            ->label('Địa chỉ chi tiết')
                            ->required()
                            ->rows(3)
                            ->placeholder('Nhập địa chỉ đầy đủ của nghĩa trang'),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(4)
                            ->placeholder('Mô tả về nghĩa trang, dịch vụ, đặc điểm...'),
                    ])
                    ->columns(2),
            ]);
    }
}
