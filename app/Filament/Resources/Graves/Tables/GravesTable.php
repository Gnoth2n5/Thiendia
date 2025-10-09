<?php

namespace App\Filament\Resources\Graves\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GravesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('grave_number')
                    ->label('Số lăng mộ')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('cemetery.district')
                    ->label('Huyện')
                    ->sortable()
                    ->searchable()
                    ->placeholder('Chưa cập nhật')
                    ->toggleable(),

                TextColumn::make('cemetery.commune')
                    ->label('Xã/Phường')
                    ->sortable()
                    ->searchable()
                    ->placeholder('Chưa cập nhật')
                    ->toggleable(),

                TextColumn::make('owner_name')
                    ->label('Chủ lăng mộ')
                    ->sortable()
                    ->searchable()
                    ->limit(25),

                TextColumn::make('deceased_full_name')
                    ->label('Người đã khuất')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('Chưa có thông tin'),

                TextColumn::make('grave_type')
                    ->label('Loại')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'đất' => 'Đất',
                        'xi_măng' => 'Xi măng',
                        'đá' => 'Đá',
                        'gỗ' => 'Gỗ',
                        'khác' => 'Khác',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'đất' => 'gray',
                        'xi_măng' => 'primary',
                        'đá' => 'success',
                        'gỗ' => 'warning',
                        'khác' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'còn_trống' => 'Còn trống',
                        'đã_sử_dụng' => 'Đã sử dụng',
                        'bảo_trì' => 'Bảo trì',
                        'ngừng_sử_dụng' => 'Ngừng sử dụng',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'còn_trống' => 'success',
                        'đã_sử_dụng' => 'primary',
                        'bảo_trì' => 'warning',
                        'ngừng_sử_dụng' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('burial_date')
                    ->label('Ngày an táng')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('cemetery.district')
                    ->label('Huyện/Thành phố')
                    ->options(array_combine(
                        array_keys(config('ninhbinh_locations')),
                        array_keys(config('ninhbinh_locations'))
                    ))
                    ->searchable(),

                SelectFilter::make('cemetery_id')
                    ->label('Nghĩa trang')
                    ->relationship('cemetery', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('grave_type')
                    ->label('Loại lăng mộ')
                    ->options([
                        'đất' => 'Lăng mộ đất',
                        'xi_măng' => 'Lăng mộ xi măng',
                        'đá' => 'Lăng mộ đá',
                        'gỗ' => 'Lăng mộ gỗ',
                        'khác' => 'Loại khác',
                    ]),

                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'còn_trống' => 'Còn trống',
                        'đã_sử_dụng' => 'Đã sử dụng',
                        'bảo_trì' => 'Bảo trì',
                        'ngừng_sử_dụng' => 'Ngừng sử dụng',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
