<?php

namespace App\Filament\Resources\Graves\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
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
                TextColumn::make('deceased_full_name')
                    ->label('Họ tên liệt sỹ')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->placeholder('Chưa có thông tin'),

                TextColumn::make('birth_year')
                    ->label('Năm sinh')
                    ->sortable()
                    ->alignCenter()
                    ->placeholder('—'),

                TextColumn::make('rank_and_unit')
                    ->label('Cấp bậc, đơn vị')
                    ->sortable()
                    ->searchable()
                    ->limit(35)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('position')
                    ->label('Chức vụ')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('deceased_death_date')
                    ->label('Ngày hy sinh')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('certificate_number')
                    ->label('Số bằng TQGC')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('decision_number')
                    ->label('Số QĐ')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('next_of_kin')
                    ->label('Thân nhân')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('cemetery.name')
                    ->label('Nghĩa trang')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

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
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
