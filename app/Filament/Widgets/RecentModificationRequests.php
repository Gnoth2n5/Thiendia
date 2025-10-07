<?php

namespace App\Filament\Widgets;

use App\Models\ModificationRequest;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentModificationRequests extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Đơn yêu cầu sửa đổi gần đây';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModificationRequest::query()
                    ->with(['grave.cemetery', 'processedBy'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('grave.cemetery.name')
                    ->label('Nghĩa trang')
                    ->limit(20),

                TextColumn::make('grave.grave_number')
                    ->label('Số lăng mộ')
                    ->weight('bold'),

                TextColumn::make('requester_name')
                    ->label('Người yêu cầu')
                    ->limit(20),

                BadgeColumn::make('request_type')
                    ->label('Loại yêu cầu')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'sửa_thông_tin' => 'Sửa thông tin',
                        'thêm_người' => 'Thêm người',
                        'xóa_người' => 'Xóa người',
                        'sửa_vị_trí' => 'Sửa vị trí',
                        'khác' => 'Khác',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'sửa_thông_tin',
                        'success' => 'thêm_người',
                        'warning' => 'xóa_người',
                        'info' => 'sửa_vị_trí',
                        'gray' => 'khác',
                    ]),

                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Chờ xử lý',
                        'approved' => 'Đã phê duyệt',
                        'rejected' => 'Đã từ chối',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
