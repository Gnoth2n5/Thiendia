<?php

namespace App\Filament\Resources\Cemeteries\Tables;

use App\Models\Cemetery;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CemeteriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Tên nghĩa trang')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('address')
                    ->label('Địa chỉ')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                TextColumn::make('graves_count')
                    ->label('Số lăng mộ')
                    ->counts('graves')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('occupied_graves')
                    ->label('Đã sử dụng')
                    ->getStateUsing(function (Cemetery $record): int {
                        return $record->graves()->where('status', 'đã_sử_dụng')->count();
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('has_graves')
                    ->label('Có lăng mộ')
                    ->options([
                        'yes' => 'Có lăng mộ',
                        'no' => 'Chưa có lăng mộ',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'yes') {
                            return $query->has('graves');
                        } elseif ($data['value'] === 'no') {
                            return $query->doesntHave('graves');
                        }
                        return $query;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
