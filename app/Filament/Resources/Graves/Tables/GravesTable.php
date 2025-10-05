<?php

namespace App\Filament\Resources\Graves\Tables;

use App\Models\Cemetery;
use App\Models\Grave;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
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

                BadgeColumn::make('grave_type')
                    ->label('Loại')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'đất' => 'Đất',
                        'xi_măng' => 'Xi măng',
                        'đá' => 'Đá',
                        'gỗ' => 'Gỗ',
                        'khác' => 'Khác',
                        default => $state,
                    })
                    ->colors([
                        'secondary' => 'đất',
                        'primary' => 'xi_măng',
                        'success' => 'đá',
                        'warning' => 'gỗ',
                        'gray' => 'khác',
                    ]),

                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'còn_trống' => 'Còn trống',
                        'đã_sử_dụng' => 'Đã sử dụng',
                        'bảo_trì' => 'Bảo trì',
                        'ngừng_sử_dụng' => 'Ngừng sử dụng',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'còn_trống',
                        'primary' => 'đã_sử_dụng',
                        'warning' => 'bảo_trì',
                        'danger' => 'ngừng_sử_dụng',
                    ]),

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
