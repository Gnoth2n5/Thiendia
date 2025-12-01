<?php

namespace App\Filament\Resources\Graves\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GravesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('STT')
                    ->getStateUsing(function ($record, $livewire) {
                        $records = $livewire->getTableRecords();

                        if ($records instanceof \Illuminate\Contracts\Pagination\Paginator) {
                            $firstItem = $records->firstItem();
                            if ($firstItem !== null) {
                                $currentIndex = 0;
                                foreach ($records as $idx => $item) {
                                    if ($item->id === $record->id) {
                                        return $firstItem + $currentIndex;
                                    }
                                    $currentIndex++;
                                }
                            }
                        }

                        // Fallback: tìm index trong collection
                        $index = 0;
                        foreach ($records as $idx => $item) {
                            if ($item->id === $record->id) {
                                return $idx + 1;
                            }
                        }

                        return 1;
                    })
                    ->alignCenter()
                    ->sortable(false),

                TextColumn::make('deceased_full_name')
                    ->label('Họ tên liệt sỹ')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->placeholder('Chưa có thông tin'),

                TextColumn::make('hometown')
                    ->label('Nguyên Quán')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—'),

                TextColumn::make('deceased_birth_date')
                    ->label('Ngày tháng năm sinh')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('enlistment_date')
                    ->label('Ngày nhập ngũ')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('deceased_death_date')
                    ->label('Ngày hy sinh')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('rank')
                    ->label('Cấp bậc')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—'),

                TextColumn::make('position')
                    ->label('Chức vụ')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—'),

                TextColumn::make('unit')
                    ->label('Đơn vị')
                    ->sortable()
                    ->searchable()
                    ->limit(35)
                    ->placeholder('—'),

                ImageColumn::make('deceased_photo')
                    ->label('Ảnh')
                    ->disk('public')
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                TextColumn::make('notes')
                    ->label('Ghi chú')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    })
                    ->placeholder('—'),
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
