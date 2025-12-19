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
                    ->limit(40)
                    ->weight('bold')
                    ->placeholder('Chưa có thông tin'),

                TextColumn::make('plot.plot_code')
                    ->label('Lô mộ')
                    ->formatStateUsing(function ($record) {
                        if ($record->plot) {
                            return $record->plot->plot_code;
                        }

                        return '—';
                    })
                    ->sortable(query: function ($query, string $direction): \Illuminate\Database\Eloquent\Builder {
                        return $query->leftJoin('cemetery_plots', 'graves.plot_id', '=', 'cemetery_plots.id')
                            ->orderBy('cemetery_plots.plot_code', $direction)
                            ->select('graves.*');
                    })
                    ->searchable(query: function ($query, string $search): \Illuminate\Database\Eloquent\Builder {
                        return $query->whereHas('plot', function ($q) use ($search) {
                            $q->where('plot_code', 'like', "%{$search}%");
                        });
                    })
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($record) => $record->plot ? 'success' : 'gray')
                    ->placeholder('—'),

                TextColumn::make('plot.position')
                    ->label('Vị trí')
                    ->formatStateUsing(function ($record) {
                        if ($record->plot) {
                            return "Hàng {$record->plot->column}, Cột {$record->plot->row}";
                        }

                        return '—';
                    })
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                TextColumn::make('plot.status')
                    ->label('Trạng thái lô')
                    ->formatStateUsing(function ($record) {
                        if ($record->plot) {
                            return match ($record->plot->status) {
                                'available' => 'Còn trống',
                                'occupied' => 'Đã sử dụng',
                                'reserved' => 'Đã đặt trước',
                                'unavailable' => 'Không khả dụng',
                                default => 'Không xác định',
                            };
                        }

                        return '—';
                    })
                    ->badge()
                    ->color(fn ($record) => match ($record->plot?->status) {
                        'available' => 'success',
                        'occupied' => 'gray',
                        'reserved' => 'warning',
                        'unavailable' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                TextColumn::make('deceased_death_date')
                    ->label('Ngày hy sinh')
                    ->date('d/m/Y')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('rank')
                    ->label('Cấp bậc')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('unit')
                    ->label('Đơn vị')
                    ->sortable()
                    ->searchable()
                    ->limit(35)
                    ->placeholder('—')
                    ->toggleable(),

                ImageColumn::make('deceased_photo')
                    ->label('Ảnh')
                    ->disk('public')
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                TextColumn::make('hometown')
                    ->label('Nguyên Quán')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deceased_birth_date')
                    ->label('Ngày sinh')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('enlistment_date')
                    ->label('Ngày nhập ngũ')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('position')
                    ->label('Chức vụ')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('notes')
                    ->label('Ghi chú')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    })
                    ->placeholder('—')
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
