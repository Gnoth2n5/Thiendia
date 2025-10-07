<?php

namespace App\Filament\Resources\ModificationRequests\Tables;

use App\Models\ModificationRequest;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ModificationRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('grave.cemetery.name')
                    ->label('Nghĩa trang')
                    ->sortable()
                    ->searchable()
                    ->limit(25),

                TextColumn::make('grave.grave_number')
                    ->label('Số lăng mộ')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('requester_name')
                    ->label('Người yêu cầu')
                    ->sortable()
                    ->searchable()
                    ->limit(25),

                TextColumn::make('requester_phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable(),

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

                TextColumn::make('processed_at')
                    ->label('Ngày xử lý')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('processedBy.name')
                    ->label('Người xử lý')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ xử lý',
                        'approved' => 'Đã phê duyệt',
                        'rejected' => 'Đã từ chối',
                    ]),

                SelectFilter::make('request_type')
                    ->label('Loại yêu cầu')
                    ->options([
                        'sửa_thông_tin' => 'Sửa thông tin',
                        'thêm_người' => 'Thêm người',
                        'xóa_người' => 'Xóa người',
                        'sửa_vị_trí' => 'Sửa vị trí',
                        'khác' => 'Khác',
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),

                    // Action phê duyệt
                    Action::make('approve')
                        ->label('Phê duyệt')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn(ModificationRequest $record): bool => $record->status === 'pending')
                        ->form([
                            Textarea::make('admin_notes')
                                ->label('Ghi chú')
                                ->placeholder('Ghi chú về việc phê duyệt...'),
                        ])
                        ->action(function (ModificationRequest $record, array $data): void {
                            $record->update([
                                'status' => 'approved',
                                'admin_notes' => $data['admin_notes'] ?? null,
                                'processed_by' => auth()->id(),
                                'processed_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Đơn yêu cầu đã được phê duyệt')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),

                    // Action từ chối
                    Action::make('reject')
                        ->label('Từ chối')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn(ModificationRequest $record): bool => $record->status === 'pending')
                        ->form([
                            Textarea::make('admin_notes')
                                ->label('Lý do từ chối')
                                ->required()
                                ->placeholder('Nhập lý do từ chối đơn yêu cầu...'),
                        ])
                        ->action(function (ModificationRequest $record, array $data): void {
                            $record->update([
                                'status' => 'rejected',
                                'admin_notes' => $data['admin_notes'],
                                'processed_by' => auth()->id(),
                                'processed_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Đơn yêu cầu đã bị từ chối')
                                ->warning()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
